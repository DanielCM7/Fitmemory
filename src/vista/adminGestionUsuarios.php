<?php
// Antes de cargar los usuarios, comprobamos si se está enviado un formulario de elminar usuario
// Así se elemina al usuario antes de cargar los usuario que permanecen
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['accion'] === 'eliminar') {
    $id_usuario = $_POST['id_usuario'];
    ControladorBD::eliminarUsuario($id_usuario);
}

// También comprobamos si se ha recibido algún formulario de actualización y se realiza si es así
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['accion'] === 'actualizar') {
    $id_usuario = $_POST['id_usuario'];
    $rol = $_POST['rol'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $contrasena_hash = $_POST['contrasena_hash'];
    $id_rol  = ControladorBD::getRolIdPorNombreRol($rol);
    ControladorBD::actualizarUsuario($id_usuario, $contrasena_hash, $nombre, $apellidos, $id_rol, $fecha_nacimiento);
}


// Almacenamos en una variable el array de usuarios que existen el la base de datos a través de la función listar usuarios que hemos creado en las funciones controlador bajo la clase ControlUsuarios
$usuarios = ControladorBD::listarUsuarios();
// Usamos la función vista que convierte un array de usuarios en una tabla
// Almacenamos en una variable la table para facilitar la inserción en el HTML
$tablaUsuarios = GeneradorTablasAdmin::tablaUsuarios($usuarios);
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
</head>

<body class="app-body d-flex align-items-center py-4 bg-body-tertiary">
    <main class="app-main form-signin w-100 m-auto">
      <?php cabeceraWeb(); ?>
            <div class="lista-users">
                <?php echo $tablaUsuarios ?>
            </div>
            <div class="">
                <button class="btn btn-outline-light btn-sm d-flex align-items-center gap-2 topbar-boton topbar-boton-ancho" type="button" onclick="window.location.href='./index.php?vista=adminCrearUsuario'">
                    <span>Añadir usuario</span>
                </button>
                <button class="btn btn-outline-light btn-sm d-flex align-items-center gap-2 topbar-boton topbar-boton-ancho" type="button" onclick="window.location.href='./index.php?vista=adminDashboard'">
                    <span>Volver al dashboard</span>
                </button>
            </div>
        </main>
    </body>
</html>
