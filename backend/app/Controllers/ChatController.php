<?php
namespace App\Controllers;

use App\Services\ApiService;

class ChatController
{
    private $apiService;
    
    public function __construct()
    {
        $this->apiService = new ApiService();
    }
    
    public function process()
    {
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        
        $input = json_decode(file_get_contents('php://input'), true);
        $message = $input['message'] ?? '';
        $modelId = $input['model'] ?? 'gpt-3.5-turbo';
        
        try {
            $response = $this->apiService->sendRequest($message, $modelId);
            echo json_encode([
                'success' => true,
                'data' => $response
            ]);
        } catch (\Exception $e) {
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }
    
    public function getModels()
    {
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        
        echo json_encode([
            'success' => true,
            'data' => $this->apiService->getAvailableModels()
        ]);
    }
}