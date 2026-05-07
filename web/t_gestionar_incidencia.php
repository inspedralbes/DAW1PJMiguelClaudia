<?php
$mysqli = include_once "conexio.php";
$incidencia = null;

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    $sql = "SELECT i.id_incidencia, i.descripcio, i.data_inici, i.data_final, 
                   i.prioritat, i.resolta, d.nom_departament,
                   t.nom_tecnic, tp.nom_tipus
            FROM INCIDENCIA i
            LEFT JOIN DEPARTAMENT d ON i.id_departament = d.id_departament
            LEFT JOIN TECNIC t ON i.id_tecnic = t.id_tecnic
            LEFT JOIN TIPUS tp ON i.id_tipus = tp.id_tipus
            WHERE i.id_incidencia = $id";
    
    $resultado = $mysqli->query($sql);
    $incidencia = $resultado->fetch_assoc();
}
?>

<?php if ($incidencia): ?>

  <div class="card">
    <div class="card-header">
      <h5 class="mb-0">Incidència #<?php echo $incidencia['id_incidencia']; ?></h5>
    </div>
    <div class="card-body">
      <div class="row g-3">

        <div class="col-md-4">
          <p class="text-muted mb-1">Departament</p>
          <p class="fw-bold"><?php echo $incidencia['nom_departament'] ?? '—'; ?></p>
        </div>

        <div class="col-md-4">
          <p class="text-muted mb-1">Prioritat</p>
          <p class="fw-bold"><?php echo $incidencia['prioritat'] ?? '—'; ?></p>
        </div>

        <div class="col-md-4">
          <p class="text-muted mb-1">Tipus</p>
          <p class="fw-bold"><?php echo $incidencia['nom_tipus'] ?? '—'; ?></p>
        </div>

        <div class="col-md-4">
          <p class="text-muted mb-1">Tècnic</p>
          <p class="fw-bold"><?php echo $incidencia['nom_tecnic'] ?? '—'; ?></p>
        </div>

        <div class="col-md-4">
          <p class="text-muted mb-1">Data inici</p>
          <p class="fw-bold"><?php echo $incidencia['data_inici'] ?? '—'; ?></p>
        </div>

        <div class="col-md-4">
          <p class="text-muted mb-1">Estat</p>
          <p class="fw-bold <?php echo $incidencia['resolta'] ? 'text-success' : 'text-danger'; ?>">
            <?php echo $incidencia['resolta'] ? 'Resolta' : 'No resolta'; ?>
          </p>
        </div>

        <div class="col-12">
          <p class="text-muted mb-1">Descripció</p>
          <p><?php echo $incidencia['descripcio']; ?></p>
        </div>

        <?php if (!$incidencia['resolta']): ?>
            <div class="col-12 mt-3">
                <form method="POST" action="tancar_incidencia.php">
                <input type="hidden" name="id_incidencia" value="<?php echo $incidencia['id_incidencia']; ?>">
                <button type="submit" class="btn btn-success">Tancar incidència</button>
                </form>
            </div>
        <?php endif; ?>

      </div>
    </div>
  </div>

<?php elseif (isset($_GET['id'])): ?>
  <div class="alert alert-danger">No s'ha trobat cap incidència amb aquest ID.</div>
<?php endif; ?>

<?php include_once "encabezado_titulo.php"; ?>
  
<a href="t_que_vols_fer.php" class="btn btn-dark text-white rounded-0 btn-sm">
      Tornar enrere
    </a>
<div class="container mt-5">
  <h1>Gestionar Incidència</h1>
  <hr>

  <form method="GET">
    <div class="d-flex gap-2 mb-4">
      <input type="number" name="id" class="form-control w-25" placeholder="Introdueix l'ID de la incidència...">
      <button type="submit" class="btn btn-primary">Buscar</button>
    </div>
  </form>

</div>

<?php include_once "pie.php"; ?>