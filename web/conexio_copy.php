<?php
$host          = "localhost";
$usuario       = "a25cladacest_projecte";
$contrasenia   = "Claudia10";
$base_de_datos = "a25cladacest_projecte";

$mysqli = new mysqli($host, $usuario, $contrasenia, $base_de_datos);

if ($mysqli->connect_errno) {
    die("Connexió fallida: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
}

return $mysqli;