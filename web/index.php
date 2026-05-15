<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include 'encabezado_titulo.php'; ?>

<div class="px-4 py-5 my-5 text-center pt-5">
 <img src="fotos/logo.jpeg" alt="Logo_Ins_Pedralbes" width="72" height="72">
 <h1 class="display-5 fw-bold text-body-emphasis">Selecciona qui ets</h1>
 <div class="col-lg-6 mx-auto">
     <p class="lead mb-4">Una vegada seleccionis qui ets t'en redigirem a un altre pagina on podras seleccionar el que pots fer</p> 
</div> 
</div>
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">

      <div class="d-flex flex-column gap-2">

        <a href="u_que_vols_fer.php"
           class="btn btn-outline-primary text-start">
          Alumne / Professor
        </a>

        <a href="ri_que_vols_fer.php"
           class="btn btn-outline-primary text-start">
          Responsable de Informatica
        </a>

        <a href="t_que_vols_fer.php"
           class="btn btn-outline-primary text-start">
          Tècnic
        </a>

        <a href="a_que_vols_fer.php"
           class="btn btn-outline-primary text-start">
          Administrador
        </a>

      </div>

    </div>
  </div>
</div>
<?php include 'pie.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>