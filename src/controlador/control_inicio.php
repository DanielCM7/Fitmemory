<?php

require_once 'controlador_BD.php';

// FICHERO CONTROLADOR: Procesa la información del formulario de inicio (login) y redirige según los datos recibidos

    // Usamos la función inicializa la sesión, usamos un if que evite un NOTICE en XAMPP
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    // Comprobamos que existen datos recogidos por el formulario
    if (isset($_POST['usuario']) && isset($_POST['contrasena'])) {
        // Utilizamos el método login de nuestra clase ControladorBD para comprobar si existe un usuario con esa contraseña 'encriptada'
        $usuario = ControladorBD::loginUsuario($_POST['usuario'], $_POST['contrasena']);
        // Si la consulta SQL existe en la tabla de usuarios
        if ($usuario) {
            // Definimos un id de sesión
            session_id(md5('Fitmemory'));
            // CREAMOS VARIABLES DE SESIÓN CON LOS DATOS DEL USUARIO EN LA TABLA USUARIO
            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            $_SESSION['id_rol'] = $usuario['id_rol'];
            $_SESSION['usuario'] = $usuario['nombre_usuario'];
            $_SESSION['nombre'] = $usuario['nombre'];
            $_SESSION['apellidos'] = $usuario['apellidos'];
            $_SESSION['fecha_nacimiento'] = $usuario['fecha_nacimiento'];
            // Creamos una variable de perfil que en base a la consulta del login guarde el valor del perfil
            $_SESSION['perfil'] = ControladorBD::getRolUsuarioPorId($_SESSION['id_rol']);
            // Creamos una variable de sesión llamada tiempo donde guardamos la hora de inicio de sesión (en segundos)
            $_SESSION['tiempo'] = time();
            header ("Location: ../../index.php");
            exit();
        } else {
            // Si el usuario y/o contraseña no existen en la base de datos continuamos en el formulario de login
            // Creamos una variable de sesión llamada error donde guardamos el mensaje de error que se mostrará en el formulario de login
            $_SESSION['error'] = "Usuario o contraseña incorrectos";
            header ("Location: ../../index.php?vista=inicio");
            exit();
        }
    } else {
        // Si no se ha enviado el formulario, mostramos el formulario
        header ("Location: ../../index.php?vista=inicio");
        exit();
    }
    ?>