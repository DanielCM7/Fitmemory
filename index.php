<?php
//NOTA DE PAULA: Tomo de referencia la estructura que aprendí para EduFlow, me parece que deja un index bastante limpio sin que la primera página sea una vista y centraliza todo a través del index.

// Definimos una constante BASE_URL para usarla en las redirecciones y enlaces, así evitamos problemas con rutas relativas
if(!defined('BASE_URL')) {
    define('BASE_URL', '/Fitmemory/');
}
// Requerimos las funciones y clases
include_once 'src/controlador/controlador_BD.php';
include_once 'src/controlador/cierre_funciones.php';
include_once 'src/controlador/controlador_enrutador.php';
include_once 'src/controlador/funciones_vista.php';

// Usamos la función inicializa la sesión, usamos un if que evite un NOTICE en XAMPP
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}



// Comprobamos si el parámetro público 'vista' NO está definido
if (!isset($_GET['vista'])) {
    // Si NO está definido, comprobamos si el parámetro público de sesión 'usuario' está definido
    if (isset($_SESSION['perfil'])) {
        // Si 'perfil' está definido, comprobamos el tipo de usuario y lo enviamos a su correspondiente dashboard
        if ($_SESSION['perfil']=="administrador") {
            header('Location: ' . BASE_URL . 'index.php?vista=adminDashboard');
        }
        if ($_SESSION['perfil']=="cliente") {
            header('Location: ' . BASE_URL . 'index.php?vista=clienteDashboard');
        }
        if ($_SESSION['perfil']=="entrenador") {
            header('Location: ' . BASE_URL . 'index.php?vista=entrenadorDashboard');
        }
    } else {
        // Si 'perfil' NO está definido, agrega el valor inicio a vista para redirigir al formulario de inicio si no se está logueado
        header('Location: ' . BASE_URL . 'index.php?vista=inicio');
    }
} else {
    // Si el parámetro 'vista' NO está definido pero el usuario sí
    if (isset($_SESSION['usuario'])) {
        // Llamamos a la función de cierre Programado
        cierreProgramado();
    }
}

// Llamamos a la función del controlador que enruta según el valor de vista
enrute();

?>
