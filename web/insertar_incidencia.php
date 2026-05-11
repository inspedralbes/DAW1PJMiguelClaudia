<?php
date_default_timezone_set('Europe/Madrid');
$mysqli = include_once "conexio.php";

// Comprovem que arribin totes les dades del formulari
// empty() retorna true si el camp esta buit o no existeix
// Si falta algun camp, aturem el script amb un missatge d'error
if (empty($_POST["id_departament"]) || empty($_POST["descripcio"])) {
    exit("Si us plau, omple tots els camps del formulari.");
}

// Recollim els valors que ha enviat l'usuari des del formulari
$id_dep      = $_POST["id_departament"];
$data_inici  = $_POST["data"];
$descripcio  = $_POST["descripcio"];

// Valors automatics que no introdueix l'usuari
$prioritat = "Mitja"; 
$resolta   = 0;

// Preparem la consulta d'insercio de forma segura amb parametres
// Aixo evita injeccions SQL
// Columnes: descripcio, data_inici, prioritat, resolta, id_departament
$sentencia = $mysqli->prepare(
    "INSERT INTO INCIDENCIA (descripcio, prioritat, resolta, id_departament) 
     VALUES (?, ?, ?, ?)"
);

// "sssii" -> string, string, string, entero, entero
$sentencia->bind_param("ssii", $descripcio, $prioritat, $resolta, $id_dep);

// Executem la consulta i comprovem si ha anat be
if ($sentencia->execute()) {
    // insert_id retorna l'ID que MySQL ha assignat automaticament a la nova incidencia
    $nou_id = $mysqli->insert_id;
    // Redirigim al formulari de confirmacio passant el nou ID per URL
    header("Location: formulari_registre_incidencia.php?id=" . $nou_id);
} else {
    // Si ha fallat, mostrem el missatge d'error de MySQL
    echo "Error al guardar la incidència: " . $mysqli->error;
}

// Tanquem l'statement per alliberar memoria
$sentencia->close();
?>