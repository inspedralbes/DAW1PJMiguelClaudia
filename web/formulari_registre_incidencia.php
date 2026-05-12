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
  
  <!-- Si el formulari s'ha enviat correctament, insertar_incidencia.php retorna -->
<!-- l'ID de la nova incidencia per GET i el mostrem aqui com a confirmacio -->
  <?php if (isset($_GET['id'])): ?>
    <div class="alert alert-success">
      Incidència creada correctament. El teu ID és: <strong><?php echo $_GET['id']; ?></strong>
    </div>
  <?php endif; ?>
  <hr>

  <!-- Formulari que envia les dades per POST a insertar_incidencia.php -->
  <form action="insertar_incidencia.php" method="POST" id="formulari">
    
    <!-- Selector de departament: cada opcio te un value amb l'ID del departament a la BD -->
    <label for="departament" class="form-label">Selecciona departament:</label>
    <select name="id_departament" id="departament" class="form-select">
        <option value="">— Selecciona un departament —</option>
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
    <textarea id="descripcio" name="descripcio" rows="3" class="form-control"></textarea>
    </div>

    <div class="mt-5">
    <button type="submit" class="btn btn-primary">Enviar</button>
    </div>
  </form>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
  </div>
</div>

<script>

  // document es l'objecte principal de JS es com si fosi tota la pagina HTML
  // getElementById("formulari") busca l'element HTML que te id="formulari"
  // addEventListener escolta un event en aquest cas "submit"
  // el function(e) es com si en java faig public voud comprobar (event e), pero function no te nom perque es anonima
  // Nomes es function(e)
  document.getElementById("formulari").addEventListener("submit", function(e){
    
    var departament = document.getElementById("departament").value;
    var descripcio  = document.getElementById("descripcio").value;

    if (departament === "") {
      e.preventDefault();
      alert("Si us plau selecciona un departament")
    }else if (descripcio.trim() === "") {
        e.preventDefault();
        alert("Si us plau, escriu una descripció!");
    }
  })

</script>


</body>
</html>