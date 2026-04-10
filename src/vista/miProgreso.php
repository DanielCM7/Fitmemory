<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario'])) {
    header("Location: " . BASE_URL . "index.php?vista=inicio");
    exit();
}

$mensajeExito = $_SESSION['exito'] ?? null;
$mensajeError = $_SESSION['error'] ?? null;
unset($_SESSION['exito'], $_SESSION['error']);

$sesionesAgrupadas = ControladorBD::obtenerSesionesAgrupadasPorUsuario($_SESSION['id_usuario']) ?? [];

$totalSesiones = count($sesionesAgrupadas);
$totalEjercicios = 0;
$totalSeries = 0;
$volumenTotal = 0.0;
$sumaRpe = 0;
$totalRegistrosConRpe = 0;
$ultimaFecha = null;

$resumenMensual = [];
$resumenGrupos = [];

foreach ($sesionesAgrupadas as $sesion) {
    if (!empty($sesion['fecha'])) {
        if ($ultimaFecha === null || strtotime($sesion['fecha']) > strtotime($ultimaFecha)) {
            $ultimaFecha = $sesion['fecha'];
        }

        $claveMes = date('Y-m', strtotime($sesion['fecha']));
        if (!isset($resumenMensual[$claveMes])) {
            $resumenMensual[$claveMes] = [
                'sesiones' => 0,
                'volumen' => 0.0
            ];
        }
        $resumenMensual[$claveMes]['sesiones']++;
    }

    foreach ($sesion['ejercicios'] as $fila) {
        $totalEjercicios++;
        $totalSeries += (int)$fila['num_serie'];

        $peso = (float)$fila['peso_real'];
        $reps = (int)$fila['repeticion_real'];
        $volumenFila = $peso * $reps;
        $volumenTotal += $volumenFila;

        if (!empty($sesion['fecha'])) {
            $claveMes = date('Y-m', strtotime($sesion['fecha']));
            $resumenMensual[$claveMes]['volumen'] += $volumenFila;
        }

        $grupo = $fila['grupo_nombre'] ?? 'Sin grupo';
        if (!isset($resumenGrupos[$grupo])) {
            $resumenGrupos[$grupo] = [
                'series' => 0,
                'reps' => 0,
                'volumen' => 0.0
            ];
        }

        $resumenGrupos[$grupo]['series'] += (int)$fila['num_serie'];
        $resumenGrupos[$grupo]['reps'] += $reps;
        $resumenGrupos[$grupo]['volumen'] += $volumenFila;

        if (isset($fila['rpe']) && (int)$fila['rpe'] > 0) {
            $sumaRpe += (int)$fila['rpe'];
            $totalRegistrosConRpe++;
        }
    }
}

function fmtVol(float $v): string
{
    return rtrim(rtrim(number_format($v, 2, ',', '.'), '0'), ',');
}

krsort($resumenMensual);
arsort($resumenGrupos);

$rpeMedio = $totalRegistrosConRpe > 0 ? round($sumaRpe / $totalRegistrosConRpe, 2) : null;

// Datos para gráficos (orden cronológico ascendente)
$resumenMensualAsc = array_reverse($resumenMensual, true);
$chartMeses    = array_map(fn ($m) => date('m/Y', strtotime($m . '-01')), array_keys($resumenMensualAsc));
$chartSesiones = array_map(fn ($d) => (int)$d['sesiones'], array_values($resumenMensualAsc));
$chartVolumen  = array_map(fn ($d) => round($d['volumen'], 2), array_values($resumenMensualAsc));
$chartGrupos   = array_keys($resumenGrupos);
$chartGruposVol = array_map(fn ($d) => round($d['volumen'], 2), array_values($resumenGrupos));
?>

<html lang="es" data-bs-theme="dark">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Fitmemory - Mi Progreso</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
    crossorigin="anonymous"
  />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="app-body d-flex align-items-center py-4 bg-body-tertiary">
  <main class="app-main app-main-sesion w-100 m-auto">
    <?php cabeceraWeb(); ?>

    <section class="panel-formulario">
      <?php if ($mensajeExito): ?>
        <div class="alert alert-success" role="alert">
          <?php echo htmlspecialchars($mensajeExito); ?>
        </div>
      <?php endif; ?>

      <?php if ($mensajeError): ?>
        <div class="alert alert-danger" role="alert">
          <?php echo htmlspecialchars($mensajeError); ?>
        </div>
      <?php endif; ?>

      <h2 class="m-0 mb-2">Mi progreso</h2>
      <p class="mb-4" style="color: var(--color-texto-suave);">
        Aqui puedes consultar un resumen de tus sesiones, volumen acumulado y evolucion mensual.
      </p>

      <?php if ($totalSesiones === 0): ?>
        <div class="alert alert-info" role="alert">
          Todavia no tienes sesiones registradas. Empieza creando una sesion para ver tu progreso.
        </div>
      <?php else: ?>

        <!-- Tarjetas de resumen -->
        <div class="row g-3 mb-4">
          <div class="col-12 col-md-6 col-xl-3">
            <div class="border rounded p-3 h-100" style="background: rgba(255,255,255,0.03);">
              <small class="d-block mb-1" style="color: var(--color-texto-suave);">Sesiones</small>
              <div class="fs-4 fw-bold"><?php echo $totalSesiones; ?></div>
            </div>
          </div>
          <div class="col-12 col-md-6 col-xl-3">
            <div class="border rounded p-3 h-100" style="background: rgba(255,255,255,0.03);">
              <small class="d-block mb-1" style="color: var(--color-texto-suave);">Registros de ejercicio</small>
              <div class="fs-4 fw-bold"><?php echo $totalEjercicios; ?></div>
            </div>
          </div>
          <div class="col-12 col-md-6 col-xl-3">
            <div class="border rounded p-3 h-100" style="background: rgba(255,255,255,0.03);">
              <small class="d-block mb-1" style="color: var(--color-texto-suave);">Series totales</small>
              <div class="fs-4 fw-bold"><?php echo $totalSeries; ?></div>
            </div>
          </div>
          <div class="col-12 col-md-6 col-xl-3">
            <div class="border rounded p-3 h-100" style="background: rgba(255,255,255,0.03);">
              <small class="d-block mb-1" style="color: var(--color-texto-suave);">RPE medio</small>
              <div class="fs-4 fw-bold">
                <?php echo $rpeMedio !== null ? fmtVol($rpeMedio) : '-'; ?>
              </div>
            </div>
          </div>
        </div>

        <!-- Gráficos -->
        <div class="row g-4 mb-4">
          <div class="col-12 col-xl-6">
            <article class="border rounded p-3 h-100">
              <h3 class="h5 mb-3">Evolucion mensual</h3>
              <canvas id="graficaMensual" height="160"></canvas>
            </article>
          </div>
          <div class="col-12 col-xl-6">
            <article class="border rounded p-3 h-100">
              <h3 class="h5 mb-3">Volumen por grupo muscular</h3>
              <canvas id="graficaGrupos" height="160"></canvas>
            </article>
          </div>
        </div>

        <!-- Tablas de detalle -->
        <div class="row g-4">
          <div class="col-12 col-xl-6">
            <article class="border rounded p-3 h-100">
              <h3 class="h5 mb-3">Detalle mensual</h3>
              <div class="table-responsive">
                <table class="table table-dark table-striped align-middle mb-0">
                  <thead>
                    <tr>
                      <th>Mes</th>
                      <th>Sesiones</th>
                      <th>Volumen</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($resumenMensual as $mes => $datosMes): ?>
                      <tr>
                        <td><?php echo htmlspecialchars(date('m/Y', strtotime($mes . '-01'))); ?></td>
                        <td><?php echo (int)$datosMes['sesiones']; ?></td>
                        <td><?php echo fmtVol($datosMes['volumen']); ?> kg</td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </article>
          </div>

          <div class="col-12 col-xl-6">
            <article class="border rounded p-3 h-100">
              <h3 class="h5 mb-3">Trabajo por grupo muscular</h3>
              <div class="table-responsive">
                <table class="table table-dark table-striped align-middle mb-0">
                  <thead>
                    <tr>
                      <th>Grupo</th>
                      <th>Series</th>
                      <th>Reps</th>
                      <th>Volumen</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($resumenGrupos as $grupo => $datosGrupo): ?>
                      <tr>
                        <td><?php echo htmlspecialchars($grupo); ?></td>
                        <td><?php echo (int)$datosGrupo['series']; ?></td>
                        <td><?php echo (int)$datosGrupo['reps']; ?></td>
                        <td><?php echo fmtVol($datosGrupo['volumen']); ?> kg</td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </article>
          </div>
        </div>

        <div class="mt-4">
          <div class="alert alert-secondary mb-0" role="alert">
            <?php if ($ultimaFecha): ?>
              Ultima sesion registrada: <?php echo htmlspecialchars(date('d/m/Y H:i', strtotime($ultimaFecha))); ?>
            <?php else: ?>
              No se ha podido determinar la fecha de la ultima sesion.
            <?php endif; ?>
          </div>
        </div>

      <?php endif; ?>

      <div class="sesion-footer-actions mt-4">
        <button class="btn btn-primary btn-lg boton-principal" type="button" onclick="window.location.href='<?php echo BASE_URL; ?>index.php?vista=crearSesionEntreno'">
          Nueva sesion
        </button>
        <button class="btn btn-secondary btn-lg boton-secundario" type="button" onclick="window.location.href='<?php echo BASE_URL; ?>index.php?vista=clienteDashboard'">
          Volver
        </button>
      </div>
    </section>
  </main>

  <?php if ($totalSesiones > 0): ?>
  <script>
    const chartMeses    = <?php echo json_encode(array_values($chartMeses), JSON_UNESCAPED_UNICODE); ?>;
    const chartSesiones = <?php echo json_encode(array_values($chartSesiones), JSON_UNESCAPED_UNICODE); ?>;
    const chartVolumen  = <?php echo json_encode(array_values($chartVolumen), JSON_UNESCAPED_UNICODE); ?>;
    const chartGrupos   = <?php echo json_encode(array_values($chartGrupos), JSON_UNESCAPED_UNICODE); ?>;
    const chartGruposVol = <?php echo json_encode(array_values($chartGruposVol), JSON_UNESCAPED_UNICODE); ?>;

    // Gráfico evolución mensual (barras + línea)
    new Chart(document.getElementById('graficaMensual'), {
      data: {
        labels: chartMeses,
        datasets: [
          {
            type: 'bar',
            label: 'Sesiones',
            data: chartSesiones,
            backgroundColor: 'rgba(37, 99, 235, 0.55)',
            borderColor: 'rgba(37, 99, 235, 0.9)',
            borderWidth: 1,
            yAxisID: 'ySesiones'
          },
          {
            type: 'line',
            label: 'Volumen (kg)',
            data: chartVolumen,
            borderColor: 'rgba(14, 165, 233, 0.9)',
            backgroundColor: 'rgba(14, 165, 233, 0.12)',
            borderWidth: 2,
            pointRadius: 4,
            tension: 0.3,
            fill: true,
            yAxisID: 'yVolumen'
          }
        ]
      },
      options: {
        responsive: true,
        interaction: { mode: 'index', intersect: false },
        plugins: {
          legend: { labels: { color: '#e5e7eb' } }
        },
        scales: {
          x: {
            ticks: { color: '#94a3b8' },
            grid:  { color: 'rgba(255,255,255,0.06)' }
          },
          ySesiones: {
            type: 'linear',
            position: 'left',
            ticks: { color: '#94a3b8', stepSize: 1 },
            grid: { color: 'rgba(255,255,255,0.06)' },
            title: { display: true, text: 'Sesiones', color: '#94a3b8' }
          },
          yVolumen: {
            type: 'linear',
            position: 'right',
            ticks: { color: '#94a3b8' },
            grid: { drawOnChartArea: false },
            title: { display: true, text: 'Volumen (kg)', color: '#94a3b8' }
          }
        }
      }
    });

    // Gráfico grupos musculares (barras horizontales)
    new Chart(document.getElementById('graficaGrupos'), {
      type: 'bar',
      data: {
        labels: chartGrupos,
        datasets: [{
          label: 'Volumen (kg)',
          data: chartGruposVol,
          backgroundColor: [
            'rgba(37,99,235,0.6)',
            'rgba(14,165,233,0.6)',
            'rgba(34,197,94,0.6)',
            'rgba(234,179,8,0.6)',
            'rgba(239,68,68,0.6)',
            'rgba(168,85,247,0.6)',
            'rgba(249,115,22,0.6)',
            'rgba(20,184,166,0.6)'
          ],
          borderColor: 'rgba(255,255,255,0.15)',
          borderWidth: 1
        }]
      },
      options: {
        indexAxis: 'y',
        responsive: true,
        plugins: {
          legend: { display: false }
        },
        scales: {
          x: {
            ticks: { color: '#94a3b8' },
            grid:  { color: 'rgba(255,255,255,0.06)' },
            title: { display: true, text: 'Volumen (kg)', color: '#94a3b8' }
          },
          y: {
            ticks: { color: '#94a3b8' },
            grid:  { color: 'rgba(255,255,255,0.06)' }
          }
        }
      }
    });
  </script>
  <?php endif; ?>
</body>
</html>