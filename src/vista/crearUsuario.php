<!doctype html>
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
      <?php include "incl/header.php"; ?>

      <form class="panel-formulario formulario-usuario" action="src/controlador/control_crear_usuario.php" method="POST">
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
          </div>
        </div>

        <div class="row mb-3 align-items-center formulario-fila">
          <label class="col-sm-4 col-form-label text-start formulario-label" for="idEdad">EDAD:</label>
          <div class="col-sm-8">
            <input
              type="number"
              class="form-control formulario-campo"
              id="idEdad"
              name="edad"
              placeholder="Edad"
            />
          </div>
        </div>

        <div class="row mb-3 align-items-center formulario-fila">
          <label class="col-sm-4 col-form-label text-start formulario-label" for="idPerfil">PERFIL:</label>
          <div class="col-sm-8">
            <input
              type="text"
              class="form-control formulario-campo"
              id="idPerfil"
              name="perfil"
              placeholder="Perfil"
            />
          </div>
        </div>

        <div class="row mb-3 align-items-center formulario-fila">
          <label class="col-sm-4 col-form-label text-start formulario-label" for="IdPassword">CONTRASEÑA:</label>
          <div class="col-sm-8">
            <input
              type="password"
              class="form-control formulario-campo"
              id="IdPassword"
              name="contrasena"
              placeholder="Contraseña"
            />
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
    </main>
  </body>
</html>