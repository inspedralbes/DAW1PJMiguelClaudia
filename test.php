<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host          = "localhost";
$usuario       = "a25cladacest_projecte";
$contrasenia   = "Claudia10";
$base_de_datos = "a25cladacest_projecte";

$mysqli = new mysqli($host, $usuario, $contrasenia, $base_de_datos);

if ($mysqli->connect_errno) {
    echo "Error: " . $mysqli->connect_error;
} else {
    echo "Connexió correcta!";
}
?>