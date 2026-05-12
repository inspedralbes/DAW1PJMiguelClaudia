<?php
$mysqli = include_once "conexio.php";

// Consulta SQL per obtenir totes les incidencies NO resoltes (resolta = 0)
// Fem un JOIN implicit entre INCIDENCIA i DEPARTAMENT per obtenir el nom del departament
// ORDER BY data_inici DESC → les mes recents primer
$sql = "SELECT i.id_incidencia, i.descripcio, i.data_inici, i.prioritat, i.resolta, d.nom_departament 
        FROM INCIDENCIA i, DEPARTAMENT d 
        WHERE i.resolta = 0
        AND i.id_departament = d.id_departament 
        ORDER BY FIELD(i.prioritat, 'Alta', 'Mitja', 'Baixa'), i.data_inici DESC";

// Executem la consulta i guardem tots els resultats en un array associatiu
$resultado = $mysqli->query($sql);
$incidencies = $resultado->fetch_all(MYSQLI_ASSOC);
// Obtenim tots els tecnics per omplir el selector del modal
$tecnics = $mysqli->query("SELECT id_tecnic, nom_tecnic FROM TECNIC ORDER BY nom_tecnic")->fetch_all(MYSQLI_ASSOC);
// Obtenim tots els tipus d'incidencia per omplir el selector del modal
$tipus = $mysqli->query("SELECT id_tipus, nom_tipus FROM TIPUS ORDER BY nom_tipus")->fetch_all(MYSQLI_ASSOC);

include_once "encabezado_titulo.php"; 
?>

<a href="ri_que_vols_fer.php" class="btn btn-dark text-white rounded-0 btn-sm">
  Tornar enrere
</a>

<div class="container mt-5">
  <h1>Llistat d'Incidències</h1>
  <table class="table table-striped">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Departament</th>
        <th>Descripció</th>
        <th>Data</th>
        <th>Prioritat</th>
        <th>Acció</th>
      </tr>
    </thead>
    <!-- Recorrem cada incidencia i mostrem una fila per cadascuna -->
    <tbody>
      <?php foreach ($incidencies as $inc): ?>
      <?php
        switch ($inc['prioritat']) {
          case 'Alta':  $classe_fila = 'table-danger';  $classe_badge = 'danger';            break;
          case 'Mitja': $classe_fila = 'table-warning'; $classe_badge = 'warning text-dark'; break;
          case 'Baixa': $classe_fila = 'table-success'; $classe_badge = 'success';           break;
        }
      ?>
      <tr class="<?php echo $classe_fila; ?>">
        <td><?php echo $inc["id_incidencia"]; ?></td>
        <td><?php echo $inc["nom_departament"]; ?></td>
        <td><?php echo $inc["descripcio"]; ?></td>
        <td><?php echo $inc["data_inici"]; ?></td>
        <td>
          <span class="badge bg-<?php echo $classe_badge; ?>">
            <?php echo $inc['prioritat']; ?>
          </span>
        </td>
        <td>
          <!-- Boto que obre el modal de modificar -->
          <!-- data-id i data-prioritat guarden les dades de la incidencia -->
          <!-- data-bs-toggle i data-bs-target obren el modal de Bootstrap -->
          <button class="btn btn-primary btn-sm btn-modificar"
            data-id="<?php echo $inc['id_incidencia']; ?>"
            data-prioritat="<?php echo $inc['prioritat']; ?>"
            data-bs-toggle="modal"
            data-bs-target="#modalModificar">
            Modificar
          </button>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<div class="modal fade" id="modalModificar" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <!-- El span #modal-id-display s'omple amb JavaScript amb el ID de la incidencia -->
        <h5 class="modal-title">Modificar Incidència <span id="modal-id-display"></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <!-- Formulari que envia les dades a guardar_incidencia.php -->
        <form method="POST" action="guardar_incidencia.php">
          <!-- Camp ocult que envia l'ID de la incidencia seleccionada -->
          <input type="hidden" name="id_incidencia" id="modal-id">

          <!-- Selector de prioritat -->
          <div class="mb-3">
            <label class="form-label">Prioritat</label>
            <select name="prioritat" id="modal-prioritat" class="form-select">
              <option value="Alta">Alta</option>
              <option value="Mitja">Mitja</option>
              <option value="Baixa">Baixa</option>
            </select>
          </div>

          <!-- Selector de tipus d'incidencia → ve de la consulta SQL de $tipus -->
          <div class="mb-3">
            <label class="form-label">Tipus</label>
            <select name="id_tipus" id="modal-tipus" class="form-select">
              <option value="">— Sense tipus —</option>
              <?php foreach ($tipus as $tip): ?>
                <option value="<?php echo $tip['id_tipus']; ?>"><?php echo $tip['nom_tipus']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Selector de tecnic assignat → ve de la consulta SQL de $tecnics -->
          <div class="mb-3">
            <label class="form-label">Tècnic</label>
            <select name="id_tecnic" id="modal-tecnic" class="form-select">
              <option value="">— Sense tècnic —</option>
              <?php foreach ($tecnics as $tec): ?>
                <option value="<?php echo $tec['id_tecnic']; ?>"><?php echo $tec['nom_tecnic']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="modal-footer">
            <!-- Boto per tancar el modal sense guardar -->
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel·lar</button>
            <!-- Boto per enviar el formulari i guardar els canvis -->
            <button type="submit" class="btn btn-success">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  // Quan l'usuari prem qualsevol boto "Modificar" de la taula:
document.querySelectorAll('.btn-modificar').forEach(btn => {
  btn.addEventListener('click', function() {
    // Omplim el camp ocult del modal amb l'ID de la incidencia clicada
    document.getElementById('modal-id').value = this.dataset.id;
    // Mostrem el ID al titol del modal (ex: "Modificar Incidencia #5")
    document.getElementById('modal-id-display').textContent = '#' + this.dataset.id;
    // Seleccionem automaticament la prioritat actual de la incidencia al selector
    document.getElementById('modal-prioritat').value = this.dataset.prioritat;
  });
});
</script>

<?php include_once "pie.php"; ?>