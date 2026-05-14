<?php
require 'vendor/autoload.php';

$client = new MongoDB\Client("mongodb+srv://a23migfulbel_db_user:XxjrzM98osKPkwIK@cluster0.l5p3abg.mongodb.net/?appName=Cluster0");
$collection = $client->logs->logs;

$ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$url = basename($_SERVER['PHP_SELF']);

if (str_starts_with($url, 'ri_'))     $usuari = 'Responsable Informàtica';
elseif (str_starts_with($url, 't_'))  $usuari = 'Tècnic';
elseif (str_starts_with($url, 'u_'))  $usuari = 'Usuari';
elseif (str_starts_with($url, 'a_'))  $usuari = 'Administrador';
else                                   $usuari = 'Altres';

$collection->insertOne([
    'url'       => $url,
    'metode'    => $_SERVER['REQUEST_METHOD'],
    'usuari_id' => $usuari,
    'timestamp' => new MongoDB\BSON\UTCDateTime(),
    'navegador' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown',
    'ip'        => $ip,
]);