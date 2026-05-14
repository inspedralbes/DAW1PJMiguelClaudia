<?php
require_once __DIR__ . "/vendor/autoload.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

//Guarda el moment exacte en què comença a executar-se la pàgina
$temps_inici = microtime(true);

//Carrega la connexió a MongoDB
$db_mongo = include_once "conexio_mongo.php";
//Selecciona la col·lecció logs (taula a sql) dins la base de dades.
$col = $db_mongo->logs;

//$_SERVER['PHP_SELF'] conté la ruta completa de la pàgina actual
//basename() elimina la ruta i deixa només el nom del fitxer
$url = basename($_SERVER['PHP_SELF']);
//Obté si la petició és GET (quan entres a una pàgina) o POST (quan envies un formulari).
$metode = $_SERVER['REQUEST_METHOD'];

//Dedueix el rol de l'usuari mirant el prefix del nom de la pàgina:
if (str_starts_with($url, 'ri_'))       $usuari_id = 'Responsable Informàtica';
elseif (str_starts_with($url, 't_'))    $usuari_id = 'Tècnic';
elseif (str_starts_with($url, 'u_'))    $usuari_id = 'Alumne/Professor';
elseif (str_starts_with($url, 'a_'))    $usuari_id = 'Administrador';
else                                     $usuari_id = 'Altres';


//Crea la data i hora actual en format MongoDB.
$timestamp = new MongoDB\BSON\UTCDateTime();
//Obté la informació del navegador del client, El ?? significa que si no existeix, posa 'desconegut'.
$navegador = $_SERVER['HTTP_USER_AGENT'] ?? 'desconegut';

//Obté la IP del client que fa la petició.
$ip = $_SERVER['REMOTE_ADDR'] ?? 'desconeguda';
//Calcula quants mil·lisegons ha tardat la pàgina:
$temps_resposta_ms = round((microtime(true) - $temps_inici) * 1000);

//Insereix un document a MongoDB amb tots els camps recollits. 
$col->insertOne([
    'url'               => $url,
    'metode'            => $metode,
    'usuari_id'         => $usuari_id,
    'timestamp'         => $timestamp,
    'navegador'         => $navegador,
    'ip'                => $ip,
    'temps_resposta_ms' => $temps_resposta_ms,
]);