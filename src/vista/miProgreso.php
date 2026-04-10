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

<!DOCTYPE html>
<html lang="es" data-bs-theme="dark">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Progreso</title>

    <!-- Iconos de la aplicación -->
    <link rel="icon" type="image/png" href="<?php echo BASE_URL; ?>assets/brand/CB0E31FB-D18E-4582-85D5-47B13AA82F4D.png"> <link rel="apple-touch-icon" href="<?php echo BASE_URL; ?>assets/brand/CB0E31FB-D18E-4582-85D5-47B13AA82F4D.png">


  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
    crossorigin="anonymous"
  />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js" defer></script>
  <script src="<?php echo BASE_URL; ?>assets/js/miProgreso.js" defer></script>
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
      <p class="mb-4 progreso-intro"> 
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
            <div class="border rounded p-3 h-100 progreso-card">
              <small class="d-block mb-1 progreso-card-label">Sesiones</small>
              <div class="fs-4 fw-bold"><?php echo $totalSesiones; ?></div>
            </div>
          </div>
          <div class="col-12 col-md-6 col-xl-3">
            <div class="border rounded p-3 h-100 progreso-card">
              <small class="d-block mb-1 progreso-card-label">Registros de ejercicio</small>
              <div class="fs-4 fw-bold"><?php echo $totalEjercicios; ?></div>
            </div>
          </div>
          <div class="col-12 col-md-6 col-xl-3">
            <div class="border rounded p-3 h-100 progreso-card">
              <small class="d-block mb-1 progreso-card-label">Series totales</small>
              <div class="fs-4 fw-bold"><?php echo $totalSeries; ?></div>
            </div>
          </div>
          <div class="col-12 col-md-6 col-xl-3">
            <div class="border rounded p-3 h-100 progreso-card">
              <small class="d-block mb-1 progreso-card-label">RPE medio</small>
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
  <a class="btn btn-primary btn-lg boton-principal" href="<?php echo BASE_URL; ?>index.php?vista=crearSesionEntreno">
    Nueva sesion
  </a>
  <a class="btn btn-secondary btn-lg boton-secundario" href="<?php echo BASE_URL; ?>index.php?vista=clienteDashboard">
    Volver
  </a>
</div>
    </section>
  </main>

    <?php if ($totalSesiones > 0): ?>
    <script id="miProgresoData" type="application/json">
      <?php
      echo json_encode([
          'chartMeses' => array_values($chartMeses),
          'chartSesiones' => array_values($chartSesiones),
          'chartVolumen' => array_values($chartVolumen),
          'chartGrupos' => array_values($chartGrupos),
          'chartGruposVol' => array_values($chartGruposVol),
      ], JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
        ?>
    </script>
  <?php endif; ?>

</body>
</html>