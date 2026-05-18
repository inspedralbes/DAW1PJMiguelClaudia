<?php
$mysqli = include_once "conexio.php";
 
$inc = null;
$actuacions = [];
$error = "";
 
// Comprovem si ha arribat un ID per la URL (?id=X)
if (isset($_GET['id']) && $_GET['id'] !== "") {
    $id_incidencia = intval($_GET['id']); // Convertim a enter per seguretat
 
    // Busquem la incidencia a la base de dades
    // JOIN implicit entre INCIDENCIA i DEPARTAMENT per obtenir el nom del departament
    // Nomes busquem incidencies NO resoltes (resolta = 0)
    $inc = $mysqli->query("SELECT i.id_incidencia, i.descripcio, i.data_inici, i.prioritat, d.nom_departament
        FROM INCIDENCIA i, DEPARTAMENT d
        WHERE i.id_incidencia = $id_incidencia
        AND i.id_departament = d.id_departament
        AND i.resolta = 0")->fetch_assoc(); // fetch_assoc retorna 1 sola fila com a array
 
    if (!$inc) {
         // Si no s'ha trobat cap incidencia oberta amb aquest ID, mostrem error
        $error = "No s'ha trobat cap incidència oberta amb aquest codi.";
    } else {
        // Si existeix, obtenim totes les actuacions d'aquesta incidencia
        // ORDER BY data_actuacio ASC → les mes antigues primer
        $actuacions = $mysqli->query("SELECT * FROM ACTUACIONS WHERE id_incidencia = $id_incidencia ORDER BY data_actuacio ASC")->fetch_all(MYSQLI_ASSOC);
    }
}
?>
<!DOCTYPE html>
<html lang="ca">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registre Actuació</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <?php include 'encabezado_titulo.php'; ?>
    <a href="t_que_vols_fer.php" class="btn btn-dark text-white rounded-0 btn-sm">
     Tornar enrere
    </a>
    <div class="container mt-4">
        <h1>Registrar Actuació</h1>
        <hr>
 
        <!-- Formulari per buscar una incidencia per ID -->
        <!-- Envia el valor per GET a la mateixa pagina (?id=X) -->
        <form method="GET" action="t_registrar_actuacio.php" class="mb-4">
            <div class="d-flex align-items-center gap-2">
                <label class="form-label fw-bold mb-0">Codi d'incidència:</label>
                <input type="number" name="id" class="form-control w-auto" min="0"
                       value="<?php echo isset($_GET['id']) ? intval($_GET['id']) : ''; ?>">
                <button type="submit" class="btn btn-primary">Continuar</button>
            </div>
        </form>

        <!-- Si hi ha error, mostrem l'alerta en vermell -->
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <!-- Nomes mostrem la resta si s'ha trobat la incidencia -->
        <?php if ($inc): ?>

        <!-- Targeta amb la informacio de la incidencia trobada -->
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

        <h5>Actuacions registrades</h5>
        <!-- Si no hi ha actuacions, mostrem un missatge informatiu -->
        <?php if (empty($actuacions)): ?>
            <p class="text-muted mb-4">Encara no hi ha actuacions per aquesta incidència.</p>
        <?php else: ?>
        <!-- Taula amb totes les actuacions existents d'aquesta incidencia -->
        <table class="table table-striped mb-4">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Data</th>
                    <th>Descripció</th>
                    <th>Temps (min)</th>
                    <th>Visible usuari</th>
                </tr>
            </thead>
            <tbody>
                <!-- $c es un contador per numerar les files (1, 2, 3...) -->
                <?php $c = 1; foreach ($actuacions as $act): ?>
                <tr>
                    <td><?php echo $c++; ?></td>
                    <td><?php echo $act['data_actuacio']; ?></td>
                    <td><?php echo $act['descripcio_detallada']; ?></td>
                    <td><?php echo $act['temps_minuts']; ?></td>
                    <!-- Si visible_usuari = 1 mostra "Si", si = 0 mostra "No" -->
                    <td><?php echo $act['visible_usuari'] ? 'Sí' : 'No'; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
 
        <!-- Targeta per afegir una nova actuacio a la incidencia -->
        <div class="card mb-4">
            <div class="card-header bg-dark text-white">
                <strong>Nova Actuació</strong>
            </div>
            <div class="card-body">
                <!-- Formulari que envia les dades a guardar_actuacio.php per POST -->
                <form method="POST" action="guardar_actuacio.php" id="formulari-actuacio">
                    <!-- Camp ocult amb l'ID de la incidencia per enviar-lo al servidor -->
                    <input type="hidden" name="id_incidencia" value="<?php echo $inc['id_incidencia']; ?>">
 
                    <!-- Camp de text per escriure la descripcio de l'actuacio -->
                    <div class="mb-3">
                        <label class="form-label">Descripció</label>
                        <textarea name="descripcio_detallada" id="descripcio-actuacio" rows="3" class="form-control"></textarea>
                    </div>
 
                    <!-- Camp numeric per indicar els minuts dedicats -->
                    <div class="mb-3">
                        <label class="form-label">Temps (minuts)</label>
                        <input type="number" name="temps_minuts" min="1" class="form-control" required>
                    </div>
 
                    <!-- Selector per triar si l'usuari pot veure aquesta actuacio -->
                    <div class="mb-3">
                        <label class="form-label">Visible per a l'usuari?</label>
                        <select name="visible_usuari" class="form-select">
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                    </div>
 
                    <!-- El name="accio" value="actuacio" indica a guardar_actuacio.php quin boto s'ha premut -->
                    <button type="submit" name="accio" value="actuacio" class="btn btn-primary">
                        Guardar Actuació
                    </button>
                </form>
            </div>
        </div>
 
        <!-- Targeta per finalitzar i tancar la incidencia -->
        <div class="card mb-5">
             <div class="card-header bg-dark text-white">
                <strong>Finalitzar Incidència</strong>
            </div>
            <div class="card-body">
                <p class="text-muted">Un cop finalitzada, la incidència no apareixerà més al llistat.</p>
                <!-- Formulari independent per finalitzar la incidencia -->
                <form method="POST" action="guardar_actuacio.php">
                    <input type="hidden" name="id_incidencia" value="<?php echo $inc['id_incidencia']; ?>">
 
                    <!-- Selector de data de finalitzacio, per defecte la data d'avui -->
                    <div class="mb-3">
                        <label class="form-label">Data de finalització</label>
                        <input type="date" name="data_final" class="form-control w-auto"
                               value="<?php echo date('Y-m-d'); ?>">
                    </div>
 
                    <!-- onclick mostra una confirmacio abans d'enviar el formulari -->
                    <!-- El name="accio" value="finalitzar" indica a guardar_actuacio.php quin boto s'ha premut -->
                    <button type="submit" name="accio" value="finalitzar" class="btn btn-primary"
                        onclick="return confirm('Segur que vols finalitzar aquesta incidència?')">
                        Marcar com a Resolta
                    </button>
                </form>
            </div>
        </div>

        <?php endif; ?>
    </div>
 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js">

    </script>

    <script>
        document.getElementById("formulari-actuacio").addEventListener("submit", function(e) {
        
        var descripcio = document.getElementById("descripcio-actuacio").value;
        
        // trim() elimina espais en blanc
        // .length retorna el numero de caracters
        if (descripcio.trim().length < 20) {
            e.preventDefault();
            alert("La descripció ha de tenir almenys 20 caràcters. Ara en té " + descripcio.trim().length + ".");
        }
        });
    </script>

    <?php include 'pie.php'; ?>

    
</body>
</html>