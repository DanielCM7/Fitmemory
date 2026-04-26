<?php

// FUNCIÓN PARA ENRUTAR DE UNA VISTA A OTRA

function enrute()
{
    // En una variable 'rol' comprobarmos el perfil de usuario guardado en la variable de sesión 'perfil'. Si no hay ninguno el rol es 'invitado'. Usaremos esto para restringir el paso a rutas manualmente desde la barra de navegador y aportar seguridad.
    $rol = $_SESSION['perfil'] ?? 'invitado';
    // Si la variable pública 'vista' ya tiene un valor asociado, usaremos un condicional de tipo switch
    // De esta forma todas las páginas se visualizarán desde el index
    if (isset($_GET['vista'])) {

        // Guardamos el valor de vista
        $vista = $_GET['vista'];

        // Haremos un array que relaciones vistas con roles
        $permisos = [
            'administrador' => ['adminDashboard', 'adminGestionUsuarios', 'adminAsignarEntrenadores', 'adminGestionarEjercicios', 'adminCrearUsuario', 'adminActualizarUsuario'],
            'cliente' => ['clienteDashboard', 'crearSesionEntreno', 'misSesiones', 'miProgreso', 'sesionCreada', 'editarPerfil'],
            'entrenador'  => ['entrenadorDashboard'],
            'invitado' => ['inicio', 'crearUsuario']
        ];

        // Si el rol no tiene permiso, forzamos al inicio o dashboard correspondiente
        if (!in_array($vista, $permisos[$rol] ?? [])) {
            if ($rol === 'administrador') {
                $vista = 'adminDashboard';
            } elseif ($rol === 'cliente') {
                $vista = 'clienteDashboard';
            } elseif ($rol === 'entrenador') {
                $vista = 'entrenadorDashboard';
            } else {
                $vista = 'inicio';
            }
        }

        switch ($vista) {
            // VISTAS ADMINISTRADOR _________________________________________________________________
            // Si el valor de 'vista' es 'adminDashboard'
            case 'adminDashboard':
                // Introducimos la vista del dashboard del administrador
                include_once "src/vista/adminDashboard.php";
                break;
             case 'adminGestionUsuarios':
                include_once "src/vista/adminGestionUsuarios.php";
                break;
            // Vamos a reutilizar la estructura de una página
            case 'adminCrearUsuario':
                include_once "src/vista/crearUsuario.php";
                break;
            case 'adminActualizarUsuario':
                include_once "src/vista/crearUsuario.php";
                break;
            case 'adminAsignarEntrenadores':
                include_once "src/vista/adminAsignarEntrenadores.php";
                break;
            case 'adminGestionarEjercicios':
                include_once "src/vista/adminGestionarEjercicios.php";
                break;


                // VISTAS CLIENTE ______________________________________________________________________
            case 'clienteDashboard':
                // Introducimos la vista del dashboard del alumno a través de la clase controlador
                include_once "src/vista/clienteDashboard.php";
                break;
            case 'crearSesionEntreno':
                // Introducimos la vista del formulario de creación de sesión de entrenamiento
                include_once "src/vista/crearSesionEntreno.php";
                break;
            case 'misSesiones':
                // Introducimos la vista para la visualización de sesiones de entrenamiento del cliente
                include_once "src/vista/misSesiones.php";
                break;
                // Introducimos la vista que indica que se ha creado la sesión de entrenamiento
                include_once "src/vista/sesionCreada.php";
                break;
            case 'miProgreso':
                // Introducimos la vista de progreso del cliente
                include_once "src/vista/miProgreso.php";
                break;
            case 'editarPerfil':
                // Introducimos la vista del formulario de edición de perfil
                include_once "src/vista/editarPerfil.php";
                break;



                // VISTAS ENTRENADOR ___________________________________________________________________
            case 'entrenadorDashboard':
                // Introducimos la vista del dashboard del profesor
                include_once "src/vista/entrenadorDashboard.php";
                break;
                // VISTAS GENERALES ___________________________________________________________________
                // Si el valor de 'vista' es 'inicio'
            case 'inicio':
                // Redirigimos al formulario de inicio
                include_once "src/vista/loginInicio.php";
                break;
                // Como valor por defecto
            case 'crearUsuario':
                // Redirigimos al formulario de inicio
                include_once "src/vista/crearUsuario.php";
                break;
                // Como valor por defecto
            default:
                // Redirigimos al formulario de inicio
                //TODO: Crear página 404 para que sea default si hay algún error
                include_once "src/vista/loginInicio.php";
                break;
        }
    }
}
