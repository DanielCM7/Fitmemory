<?php
// FICHERO VISTA: Formulario para crear un nuevo usuario, con validación de campos y mensajes de error

// VAMOS A REUTILIZARLO TANTO PARA CREAR desde inicio como invitado, como para crearlos como ADMIN, como para modificar usuarios como ADMIN

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['error'])) {
    $mensajes = $_SESSION['error'];
    unset($_SESSION['error']);
}


if ($_GET['vista'] == 'crearUsuario' || $_GET['vista'] == 'adminCrearUsuario') {
  $titulo = 'Crear Usuario';

    $usuario = "";
    $nombre = "";
    $apellidos = "";
    $fechaNac = "";
    $perfil = "";
    $contrasena = "";
    $email = "";

} elseif ($_GET['vista'] == 'adminActualizarUsuario') {
  $titulo = 'Actualizar Usuario';

  if (isset($_POST['id_usuario']) && isset($_POST['id_rol']) && isset($_POST['nombre']) && isset($_POST['apellidos']) && isset($_POST['fecha_nacimiento']) && isset($_POST['nombre_usuario']) && isset($_POST['contrasena_hash']) && isset($_POST['email'])) {

    $id = ($_POST['id_usuario']);
    $usuario = ($_POST['nombre_usuario']);
    $nombre = ($_POST['nombre']);
    $apellidos = ($_POST['apellidos']);
    $fechaNac = ($_POST['fecha_nacimiento']);
    $rol = ($_POST['id_rol']); // pasamos a minúscula
    $perfil = ControladorBD::getRolUsuarioPorId($rol);
    $contrasena = ($_POST['contrasena_hash']);
    $email = ($_POST['email']);
  }
}
?>

<html lang="es" data-bs-theme="dark">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <meta
      name="author"
      content="Mark Otto, Jacob Thornton, and Bootstrap contributors"
    />
    <meta name="generator" content="Astro v5.13.2" />
    <title>Crear Usuario</title>
    <link rel="icon" type="image/png" href="<?php echo BASE_URL; ?>assets/brand/CB0E31FB-D18E-4582-85D5-47B13AA82F4D.png"> <link rel="apple-touch-icon" href="<?php echo BASE_URL; ?>assets/brand/CB0E31FB-D18E-4582-85D5-47B13AA82F4D.png">
  <link
  href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
  rel="stylesheet"
  integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
  crossorigin="anonymous"
/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
  </head>

  <body class="app-body d-flex align-items-center py-4 bg-body-tertiary">
    <main class="app-main form-signin w-100 m-auto">
      <?php cabeceraWeb(); ?>

      <h2 class="m-0 mb-4" style="text-align:center"><?php echo $titulo;?></h2>

      <form id="formCrearUsuario" class="panel-formulario formulario-usuario" method="POST" action="<?php echo BASE_URL; ?>src/controlador/validacion_crearUsuario.php">

      <input
            type="hidden"
            name="vista"
            value="<?php echo $_GET['vista'] ?>"
        />

        <input
            type="hidden"
            name="id"
            value="<?php echo $id;?>"
        />

        <div class="row mb-3 align-items-center formulario-fila">
          <label class="col-sm-4 col-form-label text-start formulario-label" for="idUsuario">USUARIO:</label>
          <div class="col-sm-8">
            <input
              type="text"
              class="form-control formulario-campo"
              id="idUsuario"
              name="usuario"
              placeholder="Usuario"
              value="<?php echo $usuario;?>"
            />
            <!-- El div este lo tienen todos los campos del form para errores de validación -->
          <div class="error"></div>
          </div>
        </div>

        <div class="row mb-3 align-items-center formulario-fila">
          <label class="col-sm-4 col-form-label text-start formulario-label" for="idNombre">NOMBRE:</label>
          <div class="col-sm-8">
            <input
              type="text"
              class="form-control formulario-campo"
              id="idNombre"
              name="nombre"
              placeholder="Nombre"
              value="<?php echo $nombre;?>"
            />
            <div class="error"></div>
          </div>
        </div>

        <div class="row mb-3 align-items-center formulario-fila">
          <label class="col-sm-4 col-form-label text-start formulario-label" for="idApellidos">APELLIDOS:</label>
          <div class="col-sm-8">
            <input
              type="text"
              class="form-control formulario-campo"
              id="idApellidos"
              name="apellidos"
              placeholder="Apellidos"
              value="<?php echo $apellidos;?>"
            />
            <div class="error"></div>
          </div>
        </div>

        <div class="row mb-3 align-items-center formulario-fila">
          <label class="col-sm-4 col-form-label text-start formulario-label" for="idApellidos">CORREO ELECTRÓNICO:</label>
          <div class="col-sm-8">
            <input
              type="text"
              class="form-control formulario-campo"
              id="idEmail"
              name="email"
              placeholder="correo@email.com"
              value="<?php echo $email;?>"
            />
            <div class="error"></div>
          </div>
        </div>

        <!-- Paula: Voy a cambiar edad por fecha de nacimiento, porque así se recalcula con el paso del tiempo, si no un usuario tiene 33 años en 2026 y también en 2036. Voy a cambiarlo también en la BD -->
        <div class="row mb-3 align-items-center formulario-fila">
          <label class="col-sm-4 col-form-label text-start formulario-label" for="idEdad">FECHA DE NACIMIENTO:</label>
          <div class="col-sm-8">
            <input
              type="date"
              class="form-control formulario-campo"
              id="idFechaNac"
              name="fechaNac"
              min="1926-01-01"
              max=""
              value="<?php echo $fechaNac;?>"
            />
            <div class="error"></div>
          </div>
        </div>

        <div class="row mb-3 align-items-center formulario-fila">
          <label class="col-sm-4 col-form-label text-start formulario-label" for="idPerfil">PERFIL:</label>
          <div class="col-sm-8">
          <!-- NOTA: TODO He cambiado esto para que sea desplegable pero le falta css al desplegar -->
            <select
              type="text"
              class="form-control formulario-campo"
              id="idPerfil"
              name="perfil"
              placeholder="Perfil">
              <option value="none">---</option>
              <option value="Cliente" <?= $perfil == 'cliente' ? 'selected' : '' ?>>Cliente</option>
              <option value="Entrenador" <?= $perfil == 'entrenador' ? 'selected' : '' ?>>Entrenador</option>
              <?php if ($_SESSION['perfil'] == 'administrador'): ?>
                  <option value="Administrador" <?= $perfil == 'administrador' ? 'selected' : '' ?>>
                      Administrador
                  </option>
              <?php endif; ?>
            </select>
            <div class="error"></div>
          </div>
        </div>

        <div class="row mb-3 align-items-center formulario-fila">
          <label class="col-sm-4 col-form-label text-start formulario-label" for="IdPassword">CONTRASEÑA:</label>
          <div class="col-sm-8">
            <input
              type="password"
              class="form-control formulario-campo"
              id="idPassword"
              name="contrasena"
              placeholder="Contraseña"
              value=""
            />
            <div class="error"></div>
          </div>
        </div>

        <div class="acciones-formulario-centro">
          <button class="btn btn-primary btn-lg boton-principal" type="submit">
            Continuar
          </button>
          <button
            class="btn btn-secondary btn-lg boton-secundario"
            type="button"
            <?php
            if (empty($_SESSION['perfil'])) {
              $vista = 'index.php?vista=loginInicio';
            } elseif ($_SESSION['perfil'] == 'administrador') {
              $vista = 'index.php?vista=adminGestionUsuarios';
            }
            ?>
            onclick="window.location.href='<?php echo $vista; ?>'">
            Cancelar
          </button>
        </div>
      </form>
      <?php
      if (isset($mensajes)) {
          echo <<<HTML
          <div class='mensaje-usuario mensaje-error'>
        HTML;
          foreach ($mensajes as $mensaje) {
              echo <<<HTML
            <p>$mensaje</p>
          HTML;
          }
          echo <<<HTML
            </div>
          HTML;
      }
?>
    </main>
    <script>
      let perfil = "<?= $_SESSION['perfil'] ?>";
    </script>
    <script src="assets/js/crearUsuario.js"></script>
  </body>
</html>