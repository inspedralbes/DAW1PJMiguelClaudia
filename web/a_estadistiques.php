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
                    <h5 class="card-title text-primary">3.847</h5>
                    <p class="card-text text-muted small">Accessos Totals</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card text-center border-success">
                <div class="card-body">
                    <h5 class="card-title text-success">284</h5>
                    <p class="card-text text-muted small">Usuaris Únics</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card text-center border-warning">
                <div class="card-body">
                    <h5 class="card-title text-warning">142 ms</h5>
                    <p class="card-text text-muted small">Temps Mig Resposta</p>
                </div>
            </div>
        </div>
    </div>

    <!-- FILTRES -->
    <div class="card mb-4">
        <div class="card-header">Filtres</div>
        <div class="card-body">
            <div class="row g-2 align-items-end">
                <div class="col-6 col-md-2">
                    <label class="form-label small">Data inici</label>
                    <input type="date" class="form-control form-control-sm" value="2025-04-14">
                </div>
                <div class="col-6 col-md-2">
                    <label class="form-label small">Data fi</label>
                    <input type="date" class="form-control form-control-sm" value="2025-05-14">
                </div>
                <div class="col-6 col-md-3">
                    <label class="form-label small">Rol d'usuari</label>
                    <select class="form-select form-select-sm">
                        <option value="">Tots els rols</option>
                        <option>Responsable Informàtica</option>
                        <option>Tècnic</option>
                        <option>Alumne / Professor</option>
                        <option>Administrador</option>
                    </select>
                </div>
                <div class="col-6 col-md-3">
                    <label class="form-label small">Pàgina</label>
                    <select class="form-select form-select-sm">
                        <option value="">Totes les pàgines</option>
                        <option>index.php</option>
                        <option>ri_llistat_incidencies.php</option>
                        <option>t_registrar_actuacio.php</option>
                        <option>u_formulari_registre_incidencia.php</option>
                        <option>u_estat_incidencia.php</option>
                    </select>
                </div>
                <div class="col-12 col-md-2 d-flex gap-2">
                    <button class="btn btn-primary btn-sm w-100">Aplicar</button>
                    <button class="btn btn-outline-secondary btn-sm w-100">Reset</button>
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
                    <tr><td>1</td><td>index.php</td><td>842</td></tr>
                    <tr><td>2</td><td>u_formulari_registre_incidencia.php</td><td>631</td></tr>
                    <tr><td>3</td><td>ri_llistat_incidencies.php</td><td>498</td></tr>
                    <tr><td>4</td><td>t_registrar_actuacio.php</td><td>387</td></tr>
                    <tr><td>5</td><td>u_estat_incidencia.php</td><td>354</td></tr>
                    <tr><td>6</td><td>guardar_actuacio.php</td><td>283</td></tr>
                    <tr><td>7</td><td>ri_consum_departament.php</td><td>201</td></tr>
                    <tr><td>8</td><td>t_gestionar_incidencia.php</td><td>178</td></tr>
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
                    <tr><td>1</td><td><span class="badge bg-success">Tècnic</span></td><td>192.168.1.10</td><td>412</td></tr>
                    <tr><td>2</td><td><span class="badge bg-warning text-dark">Alumne/Prof.</span></td><td>192.168.1.23</td><td>388</td></tr>
                    <tr><td>3</td><td><span class="badge bg-primary">Resp. Info.</span></td><td>10.0.0.5</td><td>311</td></tr>
                    <tr><td>4</td><td><span class="badge bg-warning text-dark">Alumne/Prof.</span></td><td>192.168.1.45</td><td>276</td></tr>
                    <tr><td>5</td><td><span class="badge bg-success">Tècnic</span></td><td>192.168.2.7</td><td>198</td></tr>
                    <tr><td>6</td><td><span class="badge bg-danger">Administrador</span></td><td>10.0.0.12</td><td>97</td></tr>
                    <tr><td>7</td><td><span class="badge bg-secondary">Altres</span></td><td>10.0.0.31</td><td>44</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'pie.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const now = new Date();
    const labels = Array.from({length: 14}, (_, i) => {
        const d = new Date(now - (13 - i) * 86400000);
        return d.toLocaleDateString('ca-ES', {day: '2-digit', month: '2-digit'});
    });
    const data = Array.from({length: 14}, () => 80 + Math.floor(Math.random() * 280));

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
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });
</script>
</body>
</html>
