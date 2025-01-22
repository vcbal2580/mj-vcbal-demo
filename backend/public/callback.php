<?php
require_once __DIR__ . '/../config.php';

$data = json_decode(file_get_contents('php://input'), true);

// 验证回调
if (!isset($data['task_id']) || !isset($data['result'])) {
    http_response_code(400);
    exit('Invalid callback data');
}

// 这里可以添加处理回调的逻辑
// 比如更新数据库、触发WebSocket通知等

echo json_encode(['success' => true]);