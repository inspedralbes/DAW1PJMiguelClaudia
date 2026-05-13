<?php
// Llegeix la variable d'entorn MONGODB_URI
// En local: mongodb://usuari:1234@mongoDB:27017
// En producció (Atlas): mongodb+srv://usuari:pass@cluster.mongodb.net
$uri = getenv('MONGODB_URI') ?: 'mongodb://usuari:1234@mongoDB:27017';

// Creem el client de MongoDB passant la URI
$client = new MongoDB\Client($uri);

// Seleccionem la base de dades "logs_acces"
// Si no existeix, MongoDB la crea automàticament
$db_mongo = $client->logs_acces;

return $db_mongo;