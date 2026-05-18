<?php
$mysqli = include_once "conexio.php";
include_once "encabezado_titulo.php";

$incidencies = [];

if (isset($_GET['tecnic'])) {
    $nom_tecnic = $mysqli->real_escape_string($_GET['tecnic']);
    
    $sql = "SELECT i.id_incidencia, i.data_inici, i.prioritat,
                   COALESCE(SUM(a.temps_minuts), 0) as total_minuts
            FROM INCIDENCIA i
            INNER JOIN TECNIC t ON i.id_tecnic = t.id_tecnic
            LEFT JOIN ACTUACIONS a ON i.id_incidencia = a.id_incidencia
            WHERE i.resolta = 0
            AND t.nom_tecnic = '$nom_tecnic'
            GROUP BY i.id_incidencia, i.data_inici, i.prioritat
            ORDER BY FIELD(i.prioritat, 'Alta', 'Mitja', 'Baixa')";
    
    $resultado = $mysqli->query($sql);
    $incidencies = $resultado->fetch_all(MYSQLI_ASSOC);
}
?>

<a href="t_que_vols_fer.php" class="btn btn-dark text-white rounded-0 btn-sm">
  Tornar enrere
</a>

<div class="container mt-5">
  <h1>Informe de Tècnics</h1>
  <hr>

  <?php if (!isset($_GET['tecnic'])): ?>
    <h4>Qui ets?</h4>
    <br>
    <div class="d-flex gap-3 mt-3 justify-content-center">
      <a href="?tecnic=Gerard Torrents" class="btn btn-primary btn-lg">Gerard Torrents</a>
      <a href="?tecnic=Alvaro Pérez" class="btn btn-primary btn-lg">Alvaro Pérez</a>
      <a href="?tecnic=Ermengol Bota" class="btn btn-primary btn-lg">Ermengol Bota</a>
      <a href="?tecnic=Toni Martí" class="btn btn-primary btn-lg">Toni Martí</a>
    </div>

  <?php else: ?>
    <h3>Hola, <?php echo $_GET['tecnic']; ?>!</h3>
<p class="text-muted">Incidències assignades no resoltes</p>

<?php foreach (['Alta', 'Mitja', 'Baixa'] as $prioritat): ?>
  <h5 class="mt-4"><?php echo $prioritat; ?></h5>
  
  <?php 
  $filtrades = array_filter($incidencies, fn($i) => $i['prioritat'] === $prioritat);
  ?>

  <?php if (empty($filtrades)): ?>
    <p class="text-muted">Cap incidència</p>
  <?php else: ?>
    <table class="table table-striped">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Data inici</th>
          <th>Total temps</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($filtrades as $inc): ?>
        <tr>
          <td><?php echo $inc['id_incidencia']; ?></td>
          <td><?php echo $inc['data_inici']; ?></td>
          <td><?php echo $inc['total_minuts']; ?> min</td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>

<?php endforeach; ?>

  <?php endif; ?>

</div>

<?php include_once "pie.php"; ?>