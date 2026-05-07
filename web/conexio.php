<?php
$host          = "db";
$usuario       = "usuari";
$contrasenia   = "1234";
$base_de_datos = "incidencies";

$mysqli = new mysqli($host, $usuario, $contrasenia, $base_de_datos);

if ($mysqli->connect_errno) {
    die("Connexió fallida: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
}

return $mysqli;
