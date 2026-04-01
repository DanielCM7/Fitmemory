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

$gruposMusculares = ControladorBD::listarGruposMusculares() ?? [];
$ejerciciosPorGrupo = ControladorBD::listarEjerciciosPorGrupo();

?>

<html lang="es" data-bs-theme="dark">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Fitmemory - Nueva Sesion</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/style.css">
</head>
<body class="app-body d-flex align-items-center py-4 bg-body-tertiary">
  <main class="app-main app-main-sesion w-100 m-auto">
    <?php include "incl/header.php"; ?>

    <form action="<?php echo rtrim(BASE_URL, '/'); ?>/src/controlador/procesar_sesion_entreno.php" method="POST" class="panel-formulario panel-sesion-builder">
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

      <div class="sesion-builder-grid">
        <aside class="sesion-sidebar">
          <section class="sesion-bloque">
            <div class="sesion-bloque-titulo">Dia de entreno</div>
            <div class="sesion-date-card">
              <div class="sesion-date-icon">
                <i class="bi bi-calendar3"></i>
              </div>
              <input type="date" id="fecha" name="fecha" class="form-control formulario-campo" value="<?php echo date('Y-m-d'); ?>" required />
            </div>
          </section>

          <section class="sesion-bloque">
            <div class="sesion-bloque-titulo">Comentario</div>
            <textarea id="comentario" name="comentario" rows="6" class="form-control formulario-campo sesion-comentario" placeholder="Anota sensaciones, tecnica o cualquier detalle de la sesion."></textarea>
          </section>
        </aside>

        <section class="sesion-content">
          <div class="sesion-grid-head">
            <span>Grupo muscular</span>
            <span>Ejercicios</span>
            <span>Peso</span>
            <span>Series</span>
            <span>Rept</span>
            <span>Desc</span>
            <span>Accion</span>
          </div>

          <div id="ejerciciosContainer" class="sesion-rows">
            <div class="ejercicio-item sesion-row">
              <div class="sesion-cell" data-label="Grupo muscular">
                <select name="grupo_id[]" class="form-control formulario-campo grupo-muscular" required>
                  <option value="" selected disabled>Selecciona un grupo muscular</option>
                  <?php foreach ($gruposMusculares as $grupo): ?>
                    <option value="<?php echo (int)$grupo['id_grupo']; ?>">
                      <?php echo htmlspecialchars($grupo['nombre']); ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="sesion-cell" data-label="Ejercicios">
                <select name="ejercicio_id[]" class="form-control formulario-campo ejercicio" required>
                  <option value="" selected disabled>Selecciona un ejercicio</option>
                </select>
              </div>

              <div class="sesion-cell" data-label="Peso">
                <input type="number" name="peso[]" class="form-control formulario-campo" min="0" step="0.01" placeholder="kg" required />
              </div>

              <div class="sesion-cell" data-label="Series">
                <input type="number" name="series[]" class="form-control formulario-campo" min="1" required />
              </div>

              <div class="sesion-cell" data-label="Rept">
                <input type="number" name="repeticiones[]" class="form-control formulario-campo" min="1" required />
              </div>

              <div class="sesion-cell" data-label="Desc">
                <input type="number" name="descanso[]" class="form-control formulario-campo" min="0" value="0" required />
                <input type="hidden" name="rpe[]" value="0" />
              </div>

              <div class="sesion-cell sesion-cell-borrar" data-label="Accion">
                <button class="btn btn-outline-light eliminar-ejercicio" type="button" aria-label="Eliminar ejercicio">
                  <i class="bi bi-x-lg"></i>
                </button>
              </div>
            </div>
          </div>

          <div class="sesion-actions-inline">
            <button class="btn btn-secondary btn-lg boton-secundario" id="anadirEjercicio" type="button">
              <i class="bi bi-arrow-repeat"></i>
              Siguiente ejercicio
            </button>
          </div>
        </section>
      </div>

      <div class="sesion-footer-actions">
        <button class="btn btn-primary btn-lg boton-principal" type="submit">
          Guardar
        </button>
        <button class="btn btn-secondary btn-lg boton-secundario" type="button" onclick="window.location.href='<?php echo BASE_URL; ?>index.php?vista=clienteDashboard'">
          Inicio
        </button>
      </div>
    </form>
  </main>

  <script>
    window.ejerciciosPorGrupo = <?php echo json_encode($ejerciciosPorGrupo, JSON_UNESCAPED_UNICODE); ?>;
  </script>
  <script src="<?php echo BASE_URL; ?>/assets/js/ejerciciosPorGrupo.js"></script>
</body>
</html>
