<?php
// Carrega la connexio a la base de dades
// include_once retorna la variable $mysqli que es troba al final de conexio.php
$mysqli = include_once "conexio.php";

// Comprova que el formulari s'ha enviat mediant el mètode POST
// $_SERVER['REQUEST_METHOD'] conte el metode de la peticio (POST, GET...)
// Si algu accedeix a aquesta URL directament sense enviar el formulari, no facis res
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Recollim l'ID de la incidencia que ve de l'input hidden del formulari
    // intval() el converteix a numero enter per seguretat
    $id = intval($_POST['id_incidencia']);

    // Preparem el SQL que actualitza la incidencia
    // resolta = 1 la marca com a resolta (true)
    // data_final = NOW() guarda la data i hora actual com a data de tancament
    // WHERE id_incidencia = $id nomes afecta a AQUESTA incidencia, no a totes
    $sql = "UPDATE INCIDENCIA 
            SET resolta = 1, data_final = NOW()
            WHERE id_incidencia = $id";

    // Executem el SQL
    // Si va be redirigeix amb ?ok=1 per mostrar missatge d'exit
    // Si falla redirigeix amb ?error=1 per mostrar missatge d'error
    if ($mysqli->query($sql)) {
        header("Location: t_gestionar_incidencia.php?ok=1");
        exit;
    } else {
        header("Location: t_gestionar_incidencia.php?error=1");
        exit;
    }
}

// Si algu entra directament a aquesta URL sense POST
// el tornem a la pagina sense fer res
header("Location: t_gestionar_incidencia.php");
exit;
?>