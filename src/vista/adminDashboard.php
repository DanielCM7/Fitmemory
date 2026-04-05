


<?php
// Comprobamos que el usuario ha iniciado sesión, si no lo ha hecho redirigimos al formulario de login
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../index.php?vista=inicio");
    exit();
}
?>

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


    
      </div>
        <p class="bienvenida"> Bienvenido al panel de administración</p>

      <div class="container text-center mt-5 panel-dashboard">

        <div class="dashboard-acciones dashboard-acciones-simple">
          <button
            class="btn btn-primary btn-lg d-flex align-items-center justify-content-center gap-2 dashboard-boton"
            type="button"
            onclick="window.location.href='index.php?vista=gestionUsuarios'"
          >
            <i class="bi bi-person-gear"></i>
            Gestión de Usuarios
          </button>
        </div>

        <div class="dashboard-acciones dashboard-acciones-simple">
          <button
            class="btn btn-primary btn-lg d-flex align-items-center justify-content-center gap-2 dashboard-boton"
            type="button"
            onclick="window.location.href='index.php?vista=gestionEntrenadores'"
          >
            <i class="bi bi-people"></i>
            Asignar Entrenadores
          </button>
        </div>

        <div class="dashboard-acciones dashboard-acciones-simple">
          <button
            class="btn btn-primary btn-lg d-flex align-items-center justify-content-center gap-2 dashboard-boton"
            type="button"
            onclick="window.location.href='index.php?vista=gestionEjercicios'"
          >
            <i class="bi bi-card-list"></i>
            Gestionar Ejercicios
          </button>
        </div>
      </div>
    </main>
  </body>
</html>