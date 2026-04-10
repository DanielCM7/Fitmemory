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
?>

<html lang="es" data-bs-theme="dark">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Sesiones</title>
  <link rel="icon" type="image/png" href="<?php echo BASE_URL; ?>assets/brand/CB0E31FB-D18E-4582-85D5-47B13AA82F4D.png"> <link rel="apple-touch-icon" href="<?php echo BASE_URL; ?>assets/brand/CB0E31FB-D18E-4582-85D5-47B13AA82F4D.png">
  <link
  href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
  rel="stylesheet"
  integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
  crossorigin="anonymous"
/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
  <script src="<?php echo BASE_URL; ?>assets/js/misSesiones.js" defer></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr" defer></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js" defer></script>
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

  <h2 class="m-0 mb-4">Mis sesiones</h2>

<div class="mis-sesiones-picker">
  <label for="filtroFecha" class="mis-sesiones-filter">
    <span class="mis-sesiones-filter-label">
      <i class="bi bi-calendar3"></i>
      Filtrar por fecha
    </span>

    <input
      type="text"
      id="filtroFecha"
      class="form-control formulario-campo mis-sesiones-input"
      placeholder="Selecciona una fecha"
      readonly
    />
  </label>
</div>

  <p id="mensajeInicial" class="text-center" style="color: var(--color-texto-suave); margin-top: 1.5rem;">
    Selecciona una fecha para ver tus sesiones.
  </p>

  <?php if (empty($sesionesAgrupadas)): ?>
    <div id="sinSesiones" class="alert alert-info" style="display:none;" role="alert">
      No hay sesiones registradas para esta fecha.
    </div>
  <?php else: ?>
    <div id="sesionesContainer">
      <?php foreach ($sesionesAgrupadas as $idSesion => $sesion): ?>
        <article class="border rounded p-3 mb-4"
                 data-fecha="<?php echo date('Y-m-d', strtotime($sesion['fecha'])); ?>"
                 style="display:none;">
          <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
            <h3 class="h5 m-0">Sesion #<?php echo $idSesion; ?></h3>
            <span><?php echo htmlspecialchars(date('d/m/Y H:i', strtotime($sesion['fecha']))); ?></span>
          </div>

          <p class="mb-3">
            <strong>Comentario:</strong>
            <?php echo htmlspecialchars($sesion['comentario']); ?>
          </p>

          <?php if (empty($sesion['ejercicios'])): ?>
            <div class="alert alert-secondary mb-0" role="alert">
              Esta sesion no tiene ejercicios guardados.
            </div>
          <?php else: ?>
            <div class="table-responsive">
              <table class="table table-dark table-striped align-middle mb-0">
                <thead>
                  <tr>
                    <th>Grupo</th>
                    <th>Ejercicio</th>
                    <th>Serie</th>
                    <th>Reps</th>
                    <th>Peso</th>
                    <th>Descanso</th>
                    <th>RPE</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($sesion['ejercicios'] as $ejercicio): ?>
                    <tr>
                      <td><?php echo htmlspecialchars($ejercicio['grupo_nombre']); ?></td>
                      <td><?php echo htmlspecialchars($ejercicio['ejercicio_nombre']); ?></td>
                      <td><?php echo (int)$ejercicio['num_serie']; ?></td>
                      <td><?php echo (int)$ejercicio['repeticion_real']; ?></td>
                      <td><?php echo htmlspecialchars($ejercicio['peso_real']); ?> kg</td>
                      <td><?php echo (int)$ejercicio['descanso_real']; ?> s</td>
                      <td><?php echo (int)$ejercicio['rpe']; ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          <?php endif; ?>
        </article>
      <?php endforeach; ?>
    </div>

    <div id="sinSesiones" class="alert alert-info" style="display:none;" role="alert">
      No hay sesiones registradas para esta fecha.
    </div>
  <?php endif; ?>

  <div class="sesion-footer-actions">
    <button class="btn btn-primary btn-lg boton-principal" type="button" onclick="window.location.href='<?php echo BASE_URL; ?>index.php?vista=crearSesionEntreno'">
      Nueva sesion
    </button>
    <button class="btn btn-secondary btn-lg boton-secundario" type="button" onclick="window.location.href='<?php echo BASE_URL; ?>index.php?vista=clienteDashboard'">
      Volver
    </button>
  </div>
</section>
  </main>
</body>
</html>
