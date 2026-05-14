<?php
require_once __DIR__ . '/vendor/autoload.php';

use MongoDB\Driver\ServerApi;

$uri = 'mongodb+srv://a23migfulbel_db_user:EGfkPj1yxG551Lqd@cluster0.l5p3abg.mongodb.net/?appName=Cluster0';

$apiVersion = new ServerApi(ServerApi::V1);
$client = new MongoDB\Client($uri, [], ['serverApi' => $apiVersion]);

try {
    $client->selectDatabase('admin')->command(['ping' => 1]);
    echo "Connexió a Atlas correcta!";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage();
}