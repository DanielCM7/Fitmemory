<?php
// Vamos a volver a validar el formulario en php

// Llamamos a las funciones controlador
require_once "controlador_BD.php";

// REGEX EN PHP PARA VALIDACIONES ____________________________________
// Usuario: 3-20 caracteres, alfanuméricos, guiones y guion bajo
$usuarioRegex = "/^[a-zA-Z0-9_-]{3,20}$/";
// Nombre: 2-40 caracteres, sólo letras, espacios y tildes españolas
$nombreRegex = "/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{2,40}$/";
// Apellidos: 2-60 caracteres, sólo letras, espacios y tildes españolas
$apellidosRegex = "/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{2,60}$/";
// Contraseña: mínimo 8 caracteres, al menos una mayúscula, un número y un caracter especial
$contrasenaRegex = "/^(?=.*[A-Z])(?=.*[0-9])(?=.*[\W]).{8,}$/";



// LIMITE DE EDAD CON PHP _______________________________________________
$edadMinima = 16;
// Fecha mínima permitida
$fechaMinimaNacimiento = new DateTime();
$fechaMinimaNacimiento->modify("-{$edadMinima} years");


if (isset($_POST['usuario']) && isset($_POST['nombre']) && isset($_POST['apellidos']) && isset($_POST['fechaNac']) && isset($_POST['perfil']) && isset($_POST['contrasena']) && isset($_POST['email'])) {

    $usuario = trim($_POST['usuario']);
    $nombre = trim($_POST['nombre']);
    $apellidos = trim($_POST['apellidos']);
    $fechaNac = $_POST['fechaNac'];
    $perfil = strtolower($_POST['perfil']); // pasamos a minúscula
    $contrasena = $_POST['contrasena'];
    $email = trim($_POST['email']);

    // Comprobamos que ninguna variable haya quedado nula o vacía
    if (!$usuario|| !$nombre || !$apellidos || !$fechaNac || !$perfil || !$contrasena || !$email) {
    $errores[] = "Todos los campos son obligatorios.";
    }

    // Realizamos las mismas comprobaciones que JavaScript en caso de que se deshabilite maliciosamente
    if (!preg_match($usuarioRegex, $usuario)) {
        $errores[] = "Este nombre de usuario no es válido.";
    }
    if (!preg_match($nombreRegex, $nombre)) {
        $errores[] = "El nombre no es válido. Revise que no este usando caracteres especiales o digitos.";
    }
    if (!preg_match($apellidosRegex, $apellidos)) {
        $errores[] = "Los apellidos no son válidos. Revise que no este usando caracteres especiales o digitos.";
    }
    if (!preg_match($contrasenaRegex, $contrasena)) {
        $errores[] = "La contraseña no es válida. Debe tener mínimo 8 caracteres, entre ellos una mayúscula, un número y un caracter no alfanumérico.";
    }

   if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
         $errores[] = "El formato del email es inválido";
    }

    // Comprobamos que el perfil es válido con un añadido
    $perfil = strtolower($_POST['perfil']);
    if ($perfil !== 'administrador') {
        $perfilesValidos = ['cliente','entrenador'];
    } else {
        $perfilesValidos = ['cliente','entrenador', 'administrador'];
    }
    if (!in_array($perfil, $perfilesValidos)) {
        $errores[] = "Perfil no válido.";
    } else {
    // Si el perfil es válido comprobamos que existe en la BD y buscamos su número id para la creación de usuarios
        $id_rol = ControladorBD::getRolIdPorNombreRol ($perfil);
    }

    // Convertimos la fecha enviada por el usuario a DateTime
    $fechaNacFormat = DateTime::createFromFormat('Y-m-d', $fechaNac);
    if ($fechaNacFormat > $fechaMinimaNacimiento) {
        $errores[] = "Debes haber cumplido al menos $edadMinima para ser usuario de esta aplicación.";
    }

    // Comprobamos que no exista el usuario en la base de datos
    $existeUsuario = ControladorBD::existeUsuario($usuario);
    if ($existeUsuario){
        $errores[] = "El usuario ya existe en la base de datos.";
    }

    // Comprobamos si hay errores (el array errores no esté vacío) para redirigir, y vamos a usar variables de sesión para poder lanzar mensajes al front
    session_start();

    if (!empty($errores)) {
        $_SESSION['error'] = $errores;
         if (isset($_POST['vista'])) {
            // Guardamos el valor de vista
            $vista = $_POST['vista'];
            // El header recargara la vista que tengamos actualmente, esto permite que funcione para invitados y admin, reutilizando código
            header("Location: /Fitmemory/index.php?vista=" . urlencode($vista));
        }
        exit;
    } else {
        ControladorBD::crearUsuario($usuario, $contrasena, $nombre, $apellidos, $id_rol, $fechaNac, $email);
        $_SESSION['exito'] = 'Usuario creado correctamente.';
        if ($_SESSION['perfil'] == 'administrador') {
            header("Location: /Fitmemory/index.php?vista=adminGestionUsuarios");
        } else  {
            header("Location: /Fitmemory/index.php?vista=loginInicio");
        }
        exit;
    }

} else {
    if (isset($_POST['vista'])) {
        // Guardamos el valor de vista
        $vista = $_POST['vista'];
        // El header recargara la vista que tengamos actualmente, esto permite que funcione para invitados y admin, reutilizando código
        header("Location: /Fitmemory/index.php?vista=" . urlencode($vista));
    }
    exit;
}



?>