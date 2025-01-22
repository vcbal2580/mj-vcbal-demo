<?php
namespace App\Services;

class ApiService
{
    private $config;
    
    public function __construct()
    {
        $this->config = require __DIR__ . '/../../config.php';
        var_dump($this->config);die;
    }
    
    public function sendRequest(string $message): array
    {
        $data = [
            'message' => $message,
            'callback_url' => $this->config['callback_url']
        ];
        
        $ch = curl_init($this->config['api_url']);
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->config['api_key']
            ]
        ]);
        
        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);
        
        if ($error) {
            throw new \Exception('API request failed: ' . $error);
        }
        
        return json_decode($response, true);
    }
}