<?php
require 'vendor/autoload.php';
$uri = getenv('MONGODB_URI') ?: 'mongodb+srv://a23migfulbel_db_user:XxjrzM98osKPkwIK@cluster0.l5p3abg.mongodb.net/?appName=Cluster0';
$client = new MongoDB\Client($uri);
$collection = $client->logs->logs;
return $collection;