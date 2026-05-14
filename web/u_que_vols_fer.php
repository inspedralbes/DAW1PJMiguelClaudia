<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Que vols fer</title>
</head>
<body>
    <?php include 'encabezado_titulo.php'; ?>
    <a href="index.php" class="btn btn-dark text-white rounded-0 btn-sm">
  Tornar enrere
    </a>
    <div class="px-4 py-5 my-5 text-center">
        <img src="fotos/logo.jpeg" alt="" width="72" height="72">
        <h1 class="display-5 fw-bold text-body-emphasis">Hola Alumne/Profesor!</h1>
        <div class="col-lg-6 mx-auto">
            <p class="lead mb-4">Escull el que vols fer</p> 
            <a href="u_formulari_registre_incidencia.php">
                <button type="button" class="btn btn-primary btn-lg px-4 gap-3">Registrar Incidència</button>
            </a>
            <a href="u_estat_incidencia.php">
                <button type="button" class="btn btn-primary btn-lg px-4">Estat d'una Incidència</button> 
            </a>
        </div> 
    </div>
    <?php include 'pie.php'; ?>
</body>
</html>