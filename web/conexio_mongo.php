<?php
require 'vendor/autoload.php';
$uri = getenv('MONGODB_URI') ?: 'mongodb://usuari:1234@mongoDB:27017';
$client = new MongoDB\Client($uri);
$collection = $client->logs->logs;
return $collection;