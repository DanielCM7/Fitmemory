<?php
// FICHERO VISTA: Formulario para crear un nuevo usuario, con validación de campos y mensajes de error

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['error'])) {
    $mensajes = $_SESSION['error'];
    unset($_SESSION['error']);
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
    <title>Fitmemory</title>
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

      <form id="formCrearUsuario" class="panel-formulario formulario-usuario" method="POST" action="src/controlador/validacion_crearUsuario.php">

        <div class="row mb-3 align-items-center formulario-fila">
          <label class="col-sm-4 col-form-label text-start formulario-label" for="idUsuario">USUARIO:</label>
          <div class="col-sm-8">
            <input
              type="text"
              class="form-control formulario-campo"
              id="idUsuario"
              name="usuario"
              placeholder="Usuario"
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
              <option value="Cliente">Cliente</option>
              <option value="Entrenador">Entrenador</option>
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
            onclick="window.location.href='index.php?vista=loginInicio'">
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
    <script src="assets/js/crearUsuario.js"></script>
  </body>
</html>