<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['usuario'], $_SESSION['id_usuario'])) {
    header("Location: " . BASE_URL . "index.php?vista=inicio");
    exit();
}

$mensajeExito = $_SESSION['exito'] ?? null;
$mensajeError = $_SESSION['error'] ?? null;
unset($_SESSION['exito'], $_SESSION['error']);

$usuario = ControladorBD::obtenerUsuarioPorId($_SESSION['id_usuario']);
if (!$usuario) {
    $_SESSION['error'] = "No se ha podido cargar tu perfil.";
    header("Location: " . BASE_URL . "index.php?vista=clienteDashboard");
    exit();
}


?>
<!doctype html>
<html lang="es" data-bs-theme="dark">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Editar Perfil</title>
 
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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/air-datepicker@3.6.0/air-datepicker.css"> 
  <script src="https://cdn.jsdelivr.net/npm/air-datepicker@3.6.0/air-datepicker.js" defer></script> 
  <script src="<?php echo BASE_URL; ?>assets/js/fitmemoryDatepicker.js" defer></script>
  <script src="<?php echo BASE_URL; ?>assets/js/editarperfil.js" defer></script>
</head>

<body class="app-body d-flex align-items-center py-4 bg-body-tertiary">
  <main class="app-main app-main-sesion w-100 m-auto">
    <?php cabeceraWeb(); ?>

    <form autocomplete="off" method="POST" action="<?php echo BASE_URL; ?>src/controlador/procesar_editarPerfil.php" class="panel-formulario formulario-usuario">
      <h2 class="m-0 mb-4">Editar perfil</h2>

      <?php if ($mensajeExito): ?><div class="alert alert-success"><?php echo htmlspecialchars($mensajeExito); ?></div><?php endif; ?>
      <?php if ($mensajeError): ?><div class="alert alert-danger"><?php echo htmlspecialchars($mensajeError); ?></div><?php endif; ?>


        <div class="formulario-fila">
          <label class="formulario-label" for="contraseniaActual">Contraseña actual</label>
          <input id="contraseniaActual" name="contraseniaActual" type="password" class="form-control formulario-campo" placeholder="Contraseña actual" autocomplete="new-password" >
      </div>

      <div class="formulario-fila">
        <label class="formulario-label" for="nuevaContrasenia">Nueva contraseña</label>
        <input id="nuevaContrasenia" name="nuevaContrasenia" type="password" class="form-control formulario-campo" placeholder="Nueva contraseña" autocomplete="new-password">
      </div>

      <div class="formulario-fila">
        <label class="formulario-label" for="confirmarContrasenia">Confirmar nueva contraseña</label>
        <input id="confirmarContrasenia" name="confirmarContrasenia" type="password" class="form-control formulario-campo" placeholder="Confirmar nueva contraseña" autocomplete="new-password">
      </div>

      <div class="formulario-fila">
        <label class="formulario-label" for="usuario">Usuario</label>
        <input id="usuario" class="form-control formulario-campo" value="<?php echo htmlspecialchars($usuario['nombre_usuario']); ?>" readonly>
      </div>

      <div class="formulario-fila">
        <label class="formulario-label" for="nombre">Nombre</label>
        <input id="nombre" name="nombre" class="form-control formulario-campo" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>
      </div>

      <div class="formulario-fila">
        <label class="formulario-label" for="apellidos">Apellidos</label>
        <input id="apellidos" name="apellidos" class="form-control formulario-campo" value="<?php echo htmlspecialchars($usuario['apellidos']); ?>" required>
      </div>

<div class="formulario-fila">
  <label class="formulario-label" for="fechaNac">Fecha de nacimiento</label>
  <input
    id="fechaNac"
    name="fechaNac"
    type="text"
    class="form-control formulario-campo"
    value="<?php echo htmlspecialchars($usuario['fecha_nacimiento']); ?>"
    placeholder="Selecciona una fecha"
    required
    readonly
  >
</div>

      <div class="formulario-fila">
        <label class="formulario-label" for="email">Correo electrónico</label>
        <input id="email" name="email" type="email" class="form-control formulario-campo"
       value="<?php echo htmlspecialchars($usuario['email'] ?? ''); ?>">
      </div>

      
      <div class="sesion-footer-actions mt-4">
        <button class="btn btn-primary btn-lg boton-principal" type="submit">Guardar cambios</button>
        <a class="btn btn-secondary btn-lg boton-secundario" href="<?php echo BASE_URL; ?>index.php?vista=clienteDashboard">Volver</a>
      </div>
    </form>
  </main>
</body>
</html>
