<?php
$mysqli = include_once "conexio.php";

// Recollim l'ID de la incidencia i quin boto s'ha premut (actuacio o finalitzar)
$id_incidencia = intval($_POST['id_incidencia']);
$accio = $_POST['accio'];


// Comprovem quin boto s'ha premut per saber que hem de fer
if ($accio === 'actuacio') {
    // Recollim les dades del formulari de nova actuacio
    $descripcio    = $_POST['descripcio_detallada'];
    $temps         = intval($_POST['temps_minuts']);
    $visible       = intval($_POST['visible_usuari']);
 
    // Preparem la consulta d'insercio amb parametres per evitar injeccions SQL
    // i = enter, s = text (string)
    $stmt = $mysqli->prepare(
        "INSERT INTO ACTUACIONS (id_incidencia, descripcio_detallada, temps_minuts, visible_usuari) VALUES (?, ?, ?, ?)"
    );
    $stmt->bind_param("isii", $id_incidencia, $descripcio, $temps, $visible);
    $stmt->execute();
    $stmt->close();
 

    // Un cop guardada, tornem a la pagina de la incidencia per veure la nova actuacio
    header("Location: t_registrar_actuacio.php?id=$id_incidencia&ok=1");
    exit;
 

    //Si has premut "Marcar com a Resolta":
} elseif ($accio === 'finalitzar') {
    // Recollim la data de finalitzacio del formulari
    $data_final = $_POST['data_final'];
 
    // Actualitzem la incidencia posant resolta = 1 i guardant la data de finalitzacio
    // Aixo fa que la incidencia desaparegui del llistat del responsable d'informatica
    $stmt = $mysqli->prepare(
        "UPDATE INCIDENCIA SET resolta = 1, data_final = ? WHERE id_incidencia = ?"
    );
    $stmt->bind_param("si", $data_final, $id_incidencia);
    $stmt->execute();
    $stmt->close();
 

    //Després redirigeix al llistat:
    header("Location: ri_llistat_incidencies.php?finalitzada=1");
    exit;
}
 
// Si $accio no és ni 'actuacio' ni 'finalitzar', redirigim al llistat per defecte
header("Location: ri_llistat_incidencies.php");
exit;
?>
 
