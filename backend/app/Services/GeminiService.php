<?php

namespace App\Services;

class GeminiService
{
    private $apiKey;
    private $apiEndpoint = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent';
    
    public function __construct()
    {
        $config = require __DIR__ . '/../../config.php';
        $this->apiKey = $config['gemini_api_key'] ?? '';
    }
    
    public function generateContent(string $prompt): string
    {
        if (empty($this->apiKey)) {
            throw new \Exception('Gemini API key not configured');
        }

        $data = [
            'contents' => [
                [
                    'parts' => [
                        [
                            'text' => "You are a professional image description optimizer. Convert this simple description into a detailed image generation prompt. Focus on visual details and respond in English: $prompt"
                        ]
                    ]
                ]
            ],
            'generationConfig' => [
                'temperature' => 0.7,
                'topK' => 40,
                'topP' => 0.95,
                'maxOutputTokens' => 1024,
            ]
        ];

        $url = $this->apiEndpoint . '?key=' . $this->apiKey;
        
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json'
            ]
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        
        if ($error || $httpCode !== 200) {
            throw new \Exception('Gemini API request failed: ' . ($error ?: "HTTP $httpCode"));
        }
        
        $responseData = json_decode($response, true);
        if (!isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
            throw new \Exception('Invalid Gemini API response');
        }
        
        return $responseData['candidates'][0]['content']['parts'][0]['text'];
    }
} 