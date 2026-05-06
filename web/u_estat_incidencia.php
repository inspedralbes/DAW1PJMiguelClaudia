<?php
// Connexio a la base de dades
$mysqli = include_once "conexio.php";
 
// Inicialitzem les variables
$inc = null;        // Guardarà les dades de la incidència
$actuacions = [];   // Guardarà la llista d'actuacions
$error = "";        // Guardarà el missatge d'error si no es troba la incidència
 
// Si l'usuari ha introduït un codi i ha fet clic a "Continuar"
if (isset($_GET['id']) && $_GET['id'] !== "") {
    $id_incidencia = intval($_GET['id']); // Convertim el codi a número enter
 
    // Busquem la incidencia a la BD fent un JOIN amb DEPARTAMENT per obtenir el nom
    $inc = $mysqli->query("SELECT i.id_incidencia, i.descripcio, i.data_inici, i.prioritat, d.nom_departament
        FROM INCIDENCIA i, DEPARTAMENT d
        WHERE i.id_incidencia = $id_incidencia
        AND i.id_departament = d.id_departament")->fetch_assoc();
 
    if (!$inc) {
        // Si no existeix cap incidència amb aquest codi, guardem l'error
        $error = "No s'ha trobat cap incidència amb aquest codi.";
    } else {
        // Si existeix, busquem les actuacions visibles per l'usuari, ordenades per data
        $actuacions = $mysqli->query("SELECT data_actuacio, descripcio_detallada, temps_minuts
            FROM ACTUACIONS
            WHERE id_incidencia = $id_incidencia
            AND visible_usuari = 1
            ORDER BY data_actuacio ASC")->fetch_all(MYSQLI_ASSOC);
    }
}
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estat d'una Incidència</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'encabezado_titulo.php'; ?>
    <a href="u_que_vols_fer.php" class="btn btn-dark text-white rounded-0 btn-sm">
        Tornar enrere
    </a>
 
    <div class="container mt-4">
        <h1>Estat d'una Incidència</h1>
        <hr>
 
        <!-- Formulari per introduir el codi d'incidència -->
        <form method="GET" action="u_estat_incidencia.php" class="mb-4">
            <div class="d-flex align-items-center gap-2">
                <label class="form-label fw-bold mb-0">Codi d'incidència:</label>
                <!-- El value manté el número escrit quan es recarrega la pàgina -->
                <input type="text" name="id" class="form-control w-auto"
                       value="<?php echo isset($_GET['id']) ? intval($_GET['id']) : ''; ?>" required>
                <button type="submit" class="btn btn-primary">Continuar</button>
            </div>
        </form>
 
        <!-- Missatge d'error si no es troba la incidencia -->
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
 
        <!-- Nomes es mostra si s'ha trobat la incidencia -->
        <?php if ($inc): ?>
 
        <!-- Card amb la informació de la incidència -->
        <div class="card mb-4">
            <div class="card-header bg-dark text-white">
                <strong>Incidència #<?php echo $inc['id_incidencia']; ?></strong>
            </div>
            <div class="card-body">
                <p><strong>Departament:</strong> <?php echo $inc['nom_departament']; ?></p>
                <p><strong>Descripció:</strong> <?php echo $inc['descripcio']; ?></p>
                <p><strong>Data inici:</strong> <?php echo $inc['data_inici']; ?></p>
                <p class="mb-0"><strong>Prioritat:</strong> <?php echo $inc['prioritat']; ?></p>
            </div>
        </div>
 
        <!-- Taula amb les actuacions visibles per l'usuari -->
        <h5>Actuacions</h5>
        <?php if (empty($actuacions)): ?>
            <!-- Missatge si encara no hi ha actuacions visibles -->
            <p class="text-muted">Encara no hi ha actuacions visibles per aquesta incidència.</p>
        <?php else: ?>
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Data</th>
                        <th>Descripció</th>
                        <th>Temps (min)</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Recorrem totes les actuacions i les mostrem una per una -->
                    <?php $c = 1; foreach ($actuacions as $act): ?>
                    <tr>
                        <td><?php echo $c++; ?></td>
                        <td><?php echo $act['data_actuacio']; ?></td>
                        <td><?php echo $act['descripcio_detallada']; ?></td>
                        <td><?php echo $act['temps_minuts']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
 
        <?php endif; ?>
    </div>
 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <?php include 'pie.php'; ?>
</body>
</html>
