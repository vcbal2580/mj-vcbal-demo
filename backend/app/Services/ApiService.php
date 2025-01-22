<?php

namespace App\Services;

class ApiService
{
    private $config;
    private $openaiApiKey;
    private $geminiService;
    private $discordService;
    
    private $models = [
        'gpt-3.5-turbo' => [
            'name' => 'GPT-3.5',
            'maxTokens' => 150,
            'temperature' => 0.7,
            'service' => 'openai'
        ],
        'gpt-4' => [
            'name' => 'GPT-4',
            'maxTokens' => 300,
            'temperature' => 0.8,
            'service' => 'openai'
        ],
        'gemini-pro' => [
            'name' => 'Gemini Pro',
            'maxTokens' => 1024,
            'temperature' => 0.7,
            'service' => 'gemini'
        ],
        'direct' => [
            'name' => 'Direct (No AI)',
            'maxTokens' => 0,
            'temperature' => 0,
            'service' => 'none'
        ]
    ];
    
    public function __construct()
    {
        $this->config = require __DIR__ . '/../../config.php';
        $this->openaiApiKey = $this->config['openai_api_key'] ?? '';
        $this->geminiService = new GeminiService();
        $this->discordService = new DiscordService();
    }
    
    public function sendRequest(string $message, string $modelId = 'gpt-3.5-turbo', array $discordOptions = []): array
    {
        if ($modelId === 'direct') {
            $promptToUse = $message;
            $usedAI = false;
        } else {
            try {
                $promptToUse = $this->generatePrompt($message, $modelId);
                $usedAI = true;
            } catch (\Exception $e) {
                $promptToUse = $message;
                $usedAI = false;
            }
        }
        
        try {
            $discordResponse = $this->discordService->sendMessage($promptToUse, $discordOptions);
            
            return [
                'prompt' => $promptToUse,
                'discordChannelId' => $discordResponse['channelId'],
                'formattedPrompt' => $discordResponse['prompt'],
                'model' => $this->models[$modelId]['name'],
                'modelDetails' => [
                    'id' => $modelId,
                    'name' => $this->models[$modelId]['name'],
                    'maxTokens' => $this->models[$modelId]['maxTokens'],
                    'temperature' => $this->models[$modelId]['temperature'],
                    'service' => $this->models[$modelId]['service']
                ],
                'usedAI' => $usedAI,
                'originalMessage' => $message,
                'status' => 'Message sent to Discord'
            ];
        } catch (\Exception $e) {
            throw new \Exception('Discord integration failed: ' . $e->getMessage());
        }
    }
    
    private function generatePrompt(string $message, string $modelId): string
    {
        $model = $this->models[$modelId] ?? null;
        if (!$model) {
            throw new \Exception('Invalid model selected');
        }
        
        switch ($model['service']) {
            case 'openai':
                return $this->callChatGPT($message, $modelId);
            case 'gemini':
                return $this->geminiService->generateContent($message);
            default:
                throw new \Exception('Unsupported AI service');
        }
    }
    
    private function callChatGPT(string $message, string $modelId): string
    {
        if (empty($this->openaiApiKey)) {
            throw new \Exception('OpenAI API key not configured');
        }

        $data = [
            'model' => $modelId,
            'messages' => [
                [
                    'role' => 'system',
                    'content' => '你是一个专业的图像描述优化专家，可以将用户的简单描述转化为详细的图像生成提示词。请用英文回复，并专注于视觉细节。'
                ],
                [
                    'role' => 'user',
                    'content' => $message
                ]
            ],
            'temperature' => $this->models[$modelId]['temperature'],
            'max_tokens' => $this->models[$modelId]['maxTokens']
        ];
        
        $ch = curl_init($this->config['openai_endpoint'] ?? '');
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->openaiApiKey
            ]
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        
        if ($error || $httpCode !== 200) {
            throw new \Exception('ChatGPT API request failed: ' . ($error ?: "HTTP $httpCode"));
        }
        
        $responseData = json_decode($response, true);
        if (!isset($responseData['choices'][0]['message']['content'])) {
            throw new \Exception('Invalid ChatGPT API response');
        }
        
        return $responseData['choices'][0]['message']['content'];
    }
    
    private function callImageService(string $prompt): array
    {
        if (empty($this->config['api_key'])) {
            throw new \Exception('Image service API key not configured');
        }

        $data = [
            'prompt' => $prompt,
            'callback_url' => $this->config['callback_url'] ?? ''
        ];
        
        $ch = curl_init($this->config['api_url'] ?? '');
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . ($this->config['api_key'] ?? '')
            ]
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        
        if ($error || $httpCode !== 200) {
            throw new \Exception('Image API request failed: ' . ($error ?: "HTTP $httpCode"));
        }
        
        $responseData = json_decode($response, true);
        if (!isset($responseData['url'])) {
            throw new \Exception('Invalid image service response');
        }
        
        return $responseData;
    }
    
    public function getAvailableModels(): array
    {
        return $this->models;
    }
} 