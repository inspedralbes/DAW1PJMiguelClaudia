<?php
date_default_timezone_set('Europe/Madrid');
$mysqli = include_once "conexio.php";

// 2. Comprobamos que lleguen los datos del formulario
if (empty($_POST["id_departament"]) || empty($_POST["descripcio"])) {
    exit("Si us plau, omple tots els camps del formulari.");
}

// 3. Recogemos los valores
$id_dep      = $_POST["id_departament"];
$data_inici  = $_POST["data"];
$descripcio  = $_POST["descripcio"];

// Valores automáticos
$prioritat = "Mitja"; 
$resolta   = 0;

// 4. Preparamos la inserción 
// Columnas: descripcio, data_inici, prioritat, resolta, id_departament
$sentencia = $mysqli->prepare(
    "INSERT INTO INCIDENCIA (descripcio, prioritat, resolta, id_departament) 
     VALUES (?, ?, ?, ?)"
);

// "sssii" -> string, string, string, entero, entero
$sentencia->bind_param("ssii", $descripcio, $prioritat, $resolta, $id_dep);

// 5. Ejecutamos y comprobamos
if ($sentencia->execute()) {
    $nou_id = $mysqli->insert_id;
    header("Location: formulari_registre_incidencia.php?id=" . $nou_id);
} else {
    echo "Error al guardar la incidència: " . $mysqli->error;
}

$sentencia->close();
?>