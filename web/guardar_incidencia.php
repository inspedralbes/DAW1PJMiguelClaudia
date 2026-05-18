<?php
$mysqli = include_once "conexio.php";

// Recollim les dades que venen del formulari (mètode POST)
$id        = intval($_POST['id_incidencia']);
$prioritat = $_POST['prioritat'];
$id_tipus  = intval($_POST['id_tipus']);
$id_tecnic = intval($_POST['id_tecnic']);

// Construim la consulta SQL per actualitzar la incidencia a la base de dades
// UPDATE modifica un registre existent
// SET indica els camps que volem canviar
// WHERE assegura que només modifiquem la incidencia amb aquest ID
$sql = "UPDATE INCIDENCIA 
        SET prioritat = '$prioritat', 
            id_tipus = $id_tipus, 
            id_tecnic = $id_tecnic
        WHERE id_incidencia = $id";

// Executem la consulta amb $mysqli->query()
if ($mysqli->query($sql)) {
    // Si la consulta ha anat be → redirigim al llistat amb ?ok=1
    // Aixo permet mostrar un missatge d'exit a la pagina de desti
    header("Location: ri_llistat_incidencies.php?ok=1");
    exit;
} else {
     // Si la consulta ha fallat → redirigim al llistat amb ?error=1
    // Aixo permet mostrar un missatge d'error a la pagina de desti
    header("Location: ri_llistat_incidencies.php?error=1");
    exit;
}
?>