<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Si existe un mensaje de éxito en la sesión, lo guardamos en una variable y luego lo eliminamos de la sesión para que no se muestre nuevamente
if (isset($_SESSION['exito'])){
  $mensaje = $_SESSION['exito'];
  unset($_SESSION['exito']);
}
// Si existe un mensaje de error en la sesión, lo guardamos en una variable y luego lo eliminamos de la sesión para que no se muestre nuevamente
if (isset($_SESSION['error'])){
  $mensajeError = $_SESSION['error'];
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
    <link rel="canonical" href="index.php" />
    <link rel="stylesheet" href="assets/css/style.css" />
  </head>
<body class="app-body d-flex align-items-center py-4 bg-body-tertiary">
    <main class="app-main form-signin w-100 m-auto">
            <?php cabeceraWeb(); ?>



      <section class="panel-mensaje exito-error">
        <div class="texto-mensaje">
        <?php
          if (isset($mensaje)){
            echo <<<HTML
              <div class='mensaje-usuario mensaje-exito'>$mensaje</div>
            HTML;
          }
          if (isset($mensajeError)){
            echo <<<HTML
              <div class='mensaje-usuario mensaje-error'>$mensajeError</div>
            HTML;
          }
        ?>
        </div>
      </section>


      <!-- Paula: añado en la etiqueta form que se dirija al controlador que revisa con la BBDD las credenciales y también el método de envío del formulario (POST, por seguridad) -->
           <form class="panel-formulario login-formulario" action="src/controlador/control_inicio.php" method="POST">
        <div class="row mb-3 align-items-center formulario-fila">
      <!-- Paula: Voy a dar nomenclatura a los campos de formulario o si no es muy difícil de distinguir y procesar con php y la BBDD, y sobre todo si falta 'name' -->
       <label for="usuario" class="col-sm-4 col-form-label text-start formulario-label">USUARIO:</label>
          <div class="col-sm-8">
            <input
              type="text"
              class="form-control formulario-campo"
              id="usuario"
              name="usuario"
              placeholder="Usuario"
              focused
              required
            />
          </div>
        </div>
  <div class="row mb-3 align-items-center formulario-fila">
<label for="contrasena" class="col-sm-4 col-form-label text-start formulario-label">
CONTRASEÑA:</label>
         <div class="col-sm-8">
            <input
              type="password"
              class="form-control formulario-campo"
              id="contrasena"
              name="contrasena"
              placeholder="Contraseña"
              required
            />
          </div>
        </div>
          <div class="d-flex justify-content-end mb-3 formulario-acciones">
            <div class="form-check">
              <input
                class="form-check-input"
                type="checkbox"
                value="remember-me"
                id="checkDefault"
              />
              <label class="form-check-label" for="checkDefault">
                Recuérdame
              </label>
            </div>
          </div>

        <div class="acciones-login d-flex gap-2">
          <button class="btn btn-primary btn-lg boton-principal" type="submit">
            Iniciar Sesión
          </button>
        <!-- Paula: He cambiado que este botón sea submit, para que no acccion el action del formulario. -->
          <button
            class="btn btn-primary btn-lg boton-principal"
            type="button"
            onclick="window.location.href='index.php?vista=crearUsuario'"
          >
            Crear Usuario
          </button>
        </div>
      </form>
    </main>

    <script src="./assets/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
