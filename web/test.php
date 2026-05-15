<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'vendor/autoload.php';
$uri = getenv('MONGODB_URI') ?: 'mongodb://usuari:1234@mongoDB:27017';
echo "URI: " . $uri . "<br>";

try {
    $client = new MongoDB\Client($uri);
    $collection = $client->logs->logs;
    $total = $collection->countDocuments([]);
    echo "Total documents: " . $total;
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage();
}