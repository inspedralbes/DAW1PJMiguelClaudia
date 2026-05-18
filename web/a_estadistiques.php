<?php
require 'vendor/autoload.php';
$collection = include_once 'conexio_mongo.php';

// Total d'accessos: cuenta todos los documentos de la colección
$total_accessos = $collection->countDocuments([]);

// aggregate es como un pipeline — procesa los documentos en pasos:
//$group — agrupa por url y cuenta cuántas veces aparece cada una con $sum: 1
//$sort — ordena de más a menos visitas (-1 = descendente)
//$limit — solo las 8 primeras
$pagines = $collection->aggregate([
    ['$group' => ['_id' => '$url', 'visites' => ['$sum' => 1]]],
    ['$sort' => ['visites' => -1]],
    ['$limit' => 8]
])->toArray();

// Igual pero agrupa por ip Y usuari_id juntos — así identifica usuarios únicos por IP y rol.
$usuaris = $collection->aggregate([
    ['$group' => ['_id' => ['ip' => '$ip', 'rol' => '$usuari_id'], 'accessos' => ['$sum' => 1]]],
    ['$sort' => ['accessos' => -1]],
    ['$limit' => 7]
])->toArray();

// Agrupa por día — $dateToString convierte el timestamp a texto con formato 2026-05-15. Así cuenta los accesos de cada día para el gráfico.
$accessos_dia = $collection->aggregate([
    ['$group' => [
        '_id' => ['$dateToString' => ['format' => '%Y-%m-%d', 'date' => '$timestamp']],
        'total' => ['$sum' => 1]
    ]],
    ['$sort' => ['_id' => 1]],
    ['$limit' => 14]
])->toArray();

// Usuaris únics — conta IPs diferents
$usuaris_unics = count($collection->distinct('ip'));

// Temps mig de resposta
$temps_mig = $collection->aggregate([
    ['$group' => ['_id' => null, 'mitjana' => ['$avg' => '$temps_resposta_ms']]]
])->toArray();
$temps_mig_ms = isset($temps_mig[0]) ? round($temps_mig[0]['mitjana']) : 0;
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadístiques d'Accés</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
</head>
<body>

<?php include 'encabezado_titulo.php'; ?>

<a href="a_que_vols_fer.php" class="btn btn-dark text-white rounded-0 btn-sm">
    Tornar enrere
</a>

<div class="container mt-4">
    <h2>Estadístiques d'Accés</h2>
    <hr>

    <!-- KPIs -->
    <div class="row g-3 mb-4 justify-content-center">
        <div class="col-6 col-md-3">
            <div class="card text-center border-primary">
                <div class="card-body">
                    <h5 class="card-title text-primary"><?php echo $total_accessos; ?></h5>
                    <p class="card-text text-muted small">Accessos Totals</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card text-center border-success">
                <div class="card-body">
                    <h5 class="card-title text-success"><?php echo $usuaris_unics; ?></h5>
                    <p class="card-text text-muted small">Usuaris Únics</p>
                </div>
            </div>
        </div>

    </div>

    <!-- GRÀFIC -->
    <div class="card mb-4">
        <div class="card-header">Tendència d'accessos <span class="text-muted small">(últims 14 dies)</span></div>
        <div class="card-body">
            <canvas id="chartLine" height="80"></canvas>
        </div>
    </div>

    <!-- TAULES -->
    <div class="row g-4">
        <div class="col-md-6">
            <h5>Pàgines Més Visitades</h5>
            <table class="table table-striped table-hover table-sm">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Pàgina</th>
                        <th>Visites</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pagines as $i => $pagina): ?>
                        <tr>
                            <td><?php echo $i + 1; ?></td>
                            <td><?php echo $pagina['_id']; ?></td>
                            <td><?php echo $pagina['visites']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="col-md-6">
            <h5>Usuaris Més Actius</h5>
            <table class="table table-striped table-hover table-sm">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Rol</th>
                        <th>IP</th>
                        <th>Accessos</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuaris as $i => $usuari): ?>
                        <tr>
                            <td><?php echo $i + 1; ?></td>
                            <td><span class="badge bg-secondary"><?php echo $usuari['_id']['rol']; ?></span></td>
                            <td><?php echo $usuari['_id']['ip']; ?></td>
                            <td><?php echo $usuari['accessos']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'pie.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const labels = <?php 
    echo json_encode(array_map(fn($d) => $d['_id'], $accessos_dia));
    ?>;
    const data = <?php 
    echo json_encode(array_map(fn($d) => $d['total'], $accessos_dia));
    ?>;

    new Chart(document.getElementById('chartLine'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Accessos',
                data: data,
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13,110,253,.1)',
                borderWidth: 2,
                pointRadius: 3,
                tension: 0.3,
                fill: true
            }]
        },
        options: {
                esponsive: true,
                plugins: { legend: { display: false } },
                scales: { 
            y: { 
                beginAtZero: true 
            },
             x: {
                bounds: 'data'
            }
    }
}
    });
</script>
</body>
</html>
