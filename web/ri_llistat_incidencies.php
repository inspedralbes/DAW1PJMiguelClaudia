<?php
$mysqli = include_once "conexio.php";

$sql = "SELECT i.id_incidencia, i.descripcio, i.data_inici, i.prioritat, i.resolta, d.nom_departament 
        FROM INCIDENCIA i, DEPARTAMENT d 
        WHERE i.resolta = 0
        AND i.id_departament = d.id_departament 
        ORDER BY i.data_inici DESC";

$resultado = $mysqli->query($sql);
$incidencies = $resultado->fetch_all(MYSQLI_ASSOC);
$tecnics = $mysqli->query("SELECT id_tecnic, nom_tecnic FROM TECNIC ORDER BY nom_tecnic")->fetch_all(MYSQLI_ASSOC);
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
    <tbody>
      <?php foreach ($incidencies as $inc): ?>
      <tr>
        <td><?php echo $inc["id_incidencia"]; ?></td>
        <td><?php echo $inc["nom_departament"]; ?></td>
        <td><?php echo $inc["descripcio"]; ?></td>
        <td><?php echo $inc["data_inici"]; ?></td>
        <td><?php echo $inc["prioritat"]; ?></td>
        <td>
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
        <h5 class="modal-title">Modificar Incidència <span id="modal-id-display"></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="guardar_incidencia.php">
          <input type="hidden" name="id_incidencia" id="modal-id">
          <div class="mb-3">
            <label class="form-label">Prioritat</label>
            <select name="prioritat" id="modal-prioritat" class="form-select">
              <option value="Alta">Alta</option>
              <option value="Mitja">Mitja</option>
              <option value="Baixa">Baixa</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Tipus</label>
            <select name="id_tipus" id="modal-tipus" class="form-select">
              <option value="">— Sense tipus —</option>
              <?php foreach ($tipus as $tip): ?>
                <option value="<?php echo $tip['id_tipus']; ?>"><?php echo $tip['nom_tipus']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
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
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel·lar</button>
            <button type="submit" class="btn btn-success">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
document.querySelectorAll('.btn-modificar').forEach(btn => {
  btn.addEventListener('click', function() {
    document.getElementById('modal-id').value = this.dataset.id;
    document.getElementById('modal-id-display').textContent = '#' + this.dataset.id;
    document.getElementById('modal-prioritat').value = this.dataset.prioritat;
  });
});
</script>

<?php include_once "pie.php"; ?>