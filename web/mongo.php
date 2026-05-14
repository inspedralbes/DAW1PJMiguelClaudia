<?php
require 'vendor/autoload.php';

$client = new MongoDB\Client("mongodb://usuari:1234@mongoDB:27017");

$collection = $client->logs->logs;

// Obtenim l'adreça IP origen de la petció.
// Teniu informació sobre l'operador ?? a 
// https://phpsensei.es/operadores-en-php-null-coalesce-operator/
// "Si no es pot obtenir, es fa servir 'unknown' com a valor per defecte"

$ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$hora = date("H:i:s");

$collection->insertOne([
    'name' => 'Anna',
    'age' => 28,
    'ip_origin' => $ip,
    'date' => $hora
]);
echo "Dades inserides a demo .\n";