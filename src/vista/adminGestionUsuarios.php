<?php
// Antes de cargar los usuarios, comprobamos si se está enviado un formulario de elminar usuario
// Así se elemina al usuario antes de cargar los usuario que permanecen
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['accion'] === 'eliminar') {
    $id_usuario = $_POST['id'];
    ControladorBD::eliminarUsuario($id_usuario);
}

// También comprobamos si se ha recibido algún formulario de actualización y se realiza si es así
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['accion'] === 'actualizar') {
    $id_usuario = $_POST['id'];
    $rol = $_POST['rol'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $contrasena_hash = $_POST['contraseña'];
    $id_rol  = ControladorBD::getRolIdPorNombreRol($rol);
    ControladorBD::actualizarUsuario($id_usuario, $contrasena_hash, $nombre, $apellidos, $id_rol, $fecha_nacimiento);
}


// Obtenemos los datos de usuarios de la BD y generamos la tabla guardada en variable
$usuarios = ControladorBD::listarUsuarios();
//$tablaUsuarios = GeneradorTablasAdmin::tablaUsuarios($usuarios);

?>

<html lang="es" data-bs-theme="dark">
 <head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Fitmemory - Sesion Guardada</title>
  <link
  href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
  rel="stylesheet"
  integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
  crossorigin="anonymous"
/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>

<body class="app-body d-flex align-items-center py-4 bg-body-tertiary">
    <main class="app-main app-main-sesion w-100 m-auto" style="max-width: fit-content">
      <?php cabeceraWeb(); ?>
        <section class="panel-formulario" style="width: fit-content">
            <h2 class="m-0 mb-4">Gestión de Usuarios</h2>
                <div class="border rounded p-3 mb-4 table-responsive">
                    <div style="margin-bottom:20px">
                        <i class="bi bi-search" style="margin-right:10px"></i>
                        <input type="text" id="buscador" placeholder="Buscador..." style="width:33%">
                    </div>
                    <table id="tabla" class="table table-dark table-striped align-middle mb-0">
                    </table>
                    <?php //echo $tablaUsuarios ?>
                </div>
                <div class="sesion-footer-actions">
                    <button class="btn btn-primary btn-lg boton-principal" type="button" onclick="window.location.href='./index.php?vista=adminCrearUsuario'">
                        Añadir usuario
                    </button>
                    <button class="btn btn-secondary btn-lg boton-secundario" type="button" onclick="window.location.href='./index.php?vista=adminDashboard'">
                        Volver al dashboard
                    </button>
                </div>
            </section>
        </main>
        <script src="<?php echo BASE_URL; ?>assets/js/filtroTablasAdmin.js"></script>
        <script>
            let usuarios = <?= json_encode($usuarios) ?>;
            console.log(usuarios);
            generarTabla(usuarios);
        </script>
    </body>
</html>
