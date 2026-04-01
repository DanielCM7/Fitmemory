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
  <title>Fitmemory - Mis Sesiones</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/style.css">
</head>
<body class="app-body d-flex align-items-center py-4 bg-body-tertiary">
  <main class="app-main w-100 m-auto">
    <?php include "incl/header.php"; ?>

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

      <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h2 class="m-0">Mis sesiones</h2>
        <div class="d-flex gap-2">
          <button class="btn btn-primary" type="button" onclick="window.location.href='<?php echo BASE_URL; ?>index.php?vista=crearSesionEntreno'">
            Nueva sesion
          </button>
          <button class="btn btn-secondary" type="button" onclick="window.location.href='<?php echo BASE_URL; ?>index.php?vista=clienteDashboard'">
            Volver
          </button>
        </div>
      </div>

      <?php if (empty($sesionesAgrupadas)): ?>
        <div class="alert alert-info mb-0" role="alert">
          Todavia no has registrado ninguna sesion de entreno.
        </div>
      <?php else: ?>
        <?php foreach ($sesionesAgrupadas as $idSesion => $sesion): ?>
          <article class="border rounded p-3 mb-4">
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
      <?php endif; ?>
    </section>
  </main>
</body>
</html>
