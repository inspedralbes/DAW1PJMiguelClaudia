<!DOCTYPE html>
<html lang="ca">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registre Incidència</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <?php include 'encabezado_titulo.php'; ?>
  <a href="u_que_vols_fer.php" class="btn btn-dark text-white rounded-0 btn-sm">
  Tornar enrere
    </a>

   <div class="container">
    <div class="mx-auto">
  <h1 class="mt-5">Registrar incidència</h1>
  
  <?php if (isset($_GET['id'])): ?>
    <div class="alert alert-success">
      Incidència creada correctament. El teu ID és: <strong><?php echo $_GET['id']; ?></strong>
    </div>
  <?php endif; ?>
  <hr>

  <form action="insertar_incidencia.php" method="POST">
    
    <label for="departament" class="form-label">Selecciona departament:</label>
    <select name="id_departament" class="form-select" required>
        <option value="1">Ciències naturals</option>
        <option value="2">Informàtica</option>
        <option value="3">Matemàtiques</option>
        <option value="4">Llengua Catalana</option>
        <option value="5">Llengua Castellana</option>
        <option value="6">Ciències Socials</option>
        <option value="7">Filosofia</option>
        <option value="8">Tecnologia</option>
        <option value="9">Educació Física</option>
        <option value="10">Música</option>
        <option value="11">Educació Visual i Plàstica</option>
    </select>

    <div class="mt-5">
    <label for="descripcio" class="form-label">Descripció:</label>
    <textarea id="descripcio" name="descripcio" rows="3" class="form-control" required></textarea>
    </div>

    <div class="mt-5">
    <button type="submit" class="btn btn-primary">Enviar</button>
    </div>
  </form>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
  </div>
</div>
</body>
</html>