<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario'])) {
    header("Location: " . BASE_URL . "index.php?vista=inicio");
    exit();
}

$idSesion = filter_input(INPUT_GET, 'id_sesion', FILTER_VALIDATE_INT);

if ($idSesion === false || $idSesion === null) {
    $idSesion = (int)($_SESSION['ultima_sesion_creada'] ?? 0);
}

if ($idSesion <= 0) {
    $_SESSION['error'] = 'No se encontro la sesion solicitada.';
    header("Location: " . BASE_URL . "index.php?vista=misSesiones");
    exit();
}

$detalleSesion = ControladorBD::obtenerDetalleSesionPorIdUsuario($idSesion, $_SESSION['id_usuario']);

if (is_null($detalleSesion)) {
    $_SESSION['error'] = 'No se encontro la sesion solicitada.';
    header("Location: " . BASE_URL . "index.php?vista=misSesiones");
    exit();
}

$mensajeExito = $_SESSION['exito'] ?? 'Sesion creada correctamente.';
unset($_SESSION['exito'], $_SESSION['error'], $_SESSION['ultima_sesion_creada']);

$sesion = $detalleSesion['sesion'];
$ejerciciosSesion = $detalleSesion['ejercicios'];
$timestampSesion = strtotime($sesion['fecha']);

$dias = ['domingo', 'lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado'];
$meses = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
$tituloSesion = 'Sesion ' . $dias[(int)date('w', $timestampSesion)] . ' ' . date('j', $timestampSesion) . ' de ' . $meses[(int)date('n', $timestampSesion) - 1];
?>

<html lang="es" data-bs-theme="dark">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Fitmemory - Sesion Guardada</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/style.css">
</head>
<body class="app-body d-flex align-items-center py-4 bg-body-tertiary">
  <main class="app-main app-main-sesion w-100 m-auto">
    <?php include "incl/header.php"; ?>

    <section class="panel-formulario panel-sesion-resumen">
      <div class="sesion-resumen-titulo">
        <?php echo htmlspecialchars(strtoupper($tituloSesion)); ?>
      </div>

      <?php if (!empty($ejerciciosSesion)): ?>
        <div class="sesion-resumen-head">
          <span>Ejercicios</span>
          <span>Peso</span>
          <span>Series</span>
          <span>Rept</span>
          <span>Desc</span>
        </div>

        <div class="sesion-resumen-lista">
          <?php foreach ($ejerciciosSesion as $ejercicio): ?>
            <div class="sesion-resumen-row">
              <div class="sesion-resumen-cell sesion-resumen-cell-ejercicio" data-label="Ejercicios">
                <?php echo htmlspecialchars($ejercicio['ejercicio_nombre']); ?>
              </div>
              <div class="sesion-resumen-cell" data-label="Peso">
                <?php echo htmlspecialchars($ejercicio['peso']); ?> kg
              </div>
              <div class="sesion-resumen-cell" data-label="Series">
                <?php echo (int)$ejercicio['series']; ?>
              </div>
              <div class="sesion-resumen-cell" data-label="Rept">
                <?php echo (int)$ejercicio['repeticiones']; ?>
              </div>
              <div class="sesion-resumen-cell" data-label="Desc">
                <?php echo (int)$ejercicio['descanso']; ?> s
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <div class="alert alert-info" role="alert">
          La sesion se guardo, pero no hay ejercicios asociados.
        </div>
      <?php endif; ?>

      <?php if (!empty($sesion['comentario'])): ?>
        <div class="sesion-resumen-nota">
          <div class="sesion-bloque-titulo">Comentario</div>
          <p class="mb-0"><?php echo nl2br(htmlspecialchars($sesion['comentario'])); ?></p>
        </div>
      <?php endif; ?>

      <div class="sesion-resumen-footer">
        <div class="sesion-resumen-ok">
          <span><?php echo htmlspecialchars($mensajeExito); ?></span>
          <i class="bi bi-check-circle-fill"></i>
        </div>

        <button class="btn btn-secondary btn-lg boton-secundario" type="button" onclick="window.location.href='<?php echo BASE_URL; ?>index.php?vista=clienteDashboard'">
          Inicio
        </button>
      </div>
    </section>
  </main>
</body>
</html>
