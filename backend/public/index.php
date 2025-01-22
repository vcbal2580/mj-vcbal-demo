<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config.php';

$controller = new \App\Controllers\ChatController();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->process();
} 