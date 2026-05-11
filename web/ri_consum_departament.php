<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consum per Departaments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include 'encabezado_titulo.php'; ?>

<a href="ri_que_vols_fer.php" class="btn btn-dark text-white rounded-0 btn-sm">
    Tornar enrere
</a>

<div class="container mt-5">
    <h1>Consum per Departaments</h1>
    <hr>

    <?php
    $mysqli = include_once "conexio.php";

    $sql = "
        SELECT 
            d.id_departament,
            d.nom_departament,

            -- Subconsulta 1: compta les incidències d'aquest departament
            (
                SELECT COUNT(*)
                FROM INCIDENCIA i
                WHERE i.id_departament = d.id_departament
            ) AS total_incidencies,

            -- Subconsulta 2: suma els minuts de totes les actuacions
            -- de les incidències que pertanyen a aquest departament
            (
                SELECT COALESCE(SUM(a.temps_minuts), 0)
                FROM ACTUACIONS a
                WHERE a.id_incidencia IN (
                    -- Subconsulta niuada: obté els IDs de les incidències del departament
                    SELECT i2.id_incidencia
                    FROM INCIDENCIA i2
                    WHERE i2.id_departament = d.id_departament
                )
            ) AS total_minuts

        FROM DEPARTAMENT d
        ORDER BY total_incidencies DESC
    ";

    // Executem la consulta i guardem tots els resultats en un array associatiu
    // fetch_all(MYSQLI_ASSOC) retorna un array de files, cada fila és un array clau→valor
    $resultado = $mysqli->query($sql);
    $departaments = $resultado->fetch_all(MYSQLI_ASSOC);
    ?>

    <!-- Taula de departaments amb Bootstrap: franges gris clar (striped) i ressaltat al passar (hover) -->
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Departament</th>
                <th class="text-center">Nombre d'Incidències</th>
                <th class="text-center">Temps Total (min)</th>
            </tr>
        </thead>
        <tbody>
            <!-- Recorrem cada departament i mostrem una fila per cadascun -->
            <!-- $i és un comptador per numerar les files (1, 2, 3...) -->
            <?php $i = 1; foreach ($departaments as $dep): ?>
            <tr>
                <!-- Número de fila, s'incrementa amb $i++ després de mostrar-lo -->
                <td><?php echo $i++; ?></td>

                <!-- htmlspecialchars() evita que caràcters especials (< > & ") trenquin l'HTML -->
                <td><?php echo htmlspecialchars($dep['nom_departament']); ?></td>

                <td class="text-center">
                    <?php
                    // Triem el color del badge (etiqueta) segons el nombre d'incidències:
                    // 0        → gris    (secondary) → cap incidència
                    // 1 a 3   → verd    (success)   → poques incidències
                    // 4 a 7   → groc    (warning)   → incidències moderades
                    // 8 o més → vermell (danger)    → moltes incidències
                    $n = $dep['total_incidencies'];
                    $badge = $n == 0 ? 'secondary' : ($n <= 3 ? 'success' : ($n <= 7 ? 'warning' : 'danger'));
                    ?>
                    <!-- Badge de Bootstrap: mostra el número amb fons de color -->
                    <span class="badge bg-<?php echo $badge; ?> fs-6"><?php echo $n; ?></span>
                </td>

                <!-- Temps total en minuts tal com ve de la BD -->
                <td class="text-center"><?php echo $dep['total_minuts']; ?> min</td>

            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?php include 'pie.php'; ?>

</body>
</html>