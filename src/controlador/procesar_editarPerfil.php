<?php

require_once __DIR__ . '/controlador_BD.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['id_usuario'], $_SESSION['usuario'])) {
    header("Location: ../../index.php?vista=inicio");
    exit();
}

$contraseniaActual = trim($_POST['contraseniaActual'] ?? '');
$nuevaContrasenia = trim($_POST['nuevaContrasenia'] ?? '');
$confirmarContrasenia = trim($_POST['confirmarContrasenia'] ?? '');
$nombre = trim($_POST['nombre'] ?? '');
$apellidos = trim($_POST['apellidos'] ?? '');
$fechaNac = trim($_POST['fechaNac'] ?? '');
$correoElec = trim($_POST['email'] ?? '');

// Cargamos el usuario actual para detectar cambios reales en datos
$usuarioActual = ControladorBD::obtenerUsuarioPorId($_SESSION['id_usuario']);
if (!$usuarioActual) {
    $_SESSION['error'] = 'No se ha podido cargar tu perfil.';
    header("Location: ../../index.php?vista=editarPerfil");
    exit();
}

$quiereCambiarContrasenia = ($contraseniaActual !== '' || $nuevaContrasenia !== '' || $confirmarContrasenia !== '');

$quiereActualizarDatos =
    $nombre !== trim((string)($usuarioActual['nombre'] ?? '')) ||
    $apellidos !== trim((string)($usuarioActual['apellidos'] ?? '')) ||
    $fechaNac !== trim((string)($usuarioActual['fecha_nacimiento'] ?? '')) ||
    $correoElec !== trim((string)($usuarioActual['email'] ?? ''));

if (!$quiereCambiarContrasenia && !$quiereActualizarDatos) {
    $_SESSION['error'] = 'No se han detectado cambios para actualizar.';
    header("Location: ../../index.php?vista=editarPerfil");
    exit();
}

$seActualizoDatos = false;
$seActualizoContrasenia = false;

// Flujo independiente: actualizar datos
if ($quiereActualizarDatos) {
    if ($nombre === '' || $apellidos === '' || $fechaNac === '') {
        $_SESSION['error'] = 'Completa nombre, apellidos y fecha para actualizar tus datos.';
        header("Location: ../../index.php?vista=editarPerfil");
        exit();
    }

    $fechaNacimiento = DateTime::createFromFormat('Y-m-d', $fechaNac);
    $erroresFecha = DateTime::getLastErrors();
    if ($erroresFecha === false) {
        $erroresFecha = ['warning_count' => 0, 'error_count' => 0];
    }
    $fechaNoValida =
        !$fechaNacimiento ||
        ($erroresFecha['warning_count'] ?? 0) > 0 ||
        ($erroresFecha['error_count'] ?? 0) > 0 ||
        $fechaNacimiento->format('Y-m-d') !== $fechaNac;

    if ($fechaNoValida) {
        $_SESSION['error'] = 'La fecha de nacimiento no es valida.';
        header("Location: ../../index.php?vista=editarPerfil");
        exit();
    }

    if ($fechaNacimiento > new DateTime('today')) {
        $_SESSION['error'] = 'La fecha de nacimiento no puede estar en el futuro.';
        header("Location: ../../index.php?vista=editarPerfil");
        exit();
    }

    $okDatos = ControladorBD::actualizarPerfilUsuario(
        $_SESSION['id_usuario'],
        $nombre,
        $apellidos,
        $fechaNac,
        $correoElec
    );

    if (!$okDatos) {
        $_SESSION['error'] = 'No se pudieron actualizar los datos del perfil.';
        header("Location: ../../index.php?vista=editarPerfil");
        exit();
    }

    $seActualizoDatos = true;
    $_SESSION['nombre'] = $nombre;
    $_SESSION['apellidos'] = $apellidos;
    $_SESSION['fecha_nacimiento'] = $fechaNac;
    $_SESSION['correo_electronico'] = $correoElec;
}

// Flujo independiente: cambiar contraseña
if ($quiereCambiarContrasenia) {
    if ($contraseniaActual === '' || $nuevaContrasenia === '' || $confirmarContrasenia === '') {
        $_SESSION['error'] = 'Para cambiar la contraseña, completa los tres campos de contraseña.';
        header("Location: ../../index.php?vista=editarPerfil");
        exit();
    }

    if ($nuevaContrasenia !== $confirmarContrasenia) {
        $_SESSION['error'] = 'La nueva contraseña y su confirmación no coinciden.';
        header("Location: ../../index.php?vista=editarPerfil");
        exit();
    }

    $usuarioValido = ControladorBD::loginUsuario($_SESSION['usuario'], $contraseniaActual);
    if (!$usuarioValido) {
        $_SESSION['error'] = 'La contraseña actual no es correcta.';
        header("Location: ../../index.php?vista=editarPerfil");
        exit();
    }

    $okContrasenia = ControladorBD::cambiarContrasena($_SESSION['usuario'], $nuevaContrasenia);
    if (!$okContrasenia) {
        $_SESSION['error'] = 'No se pudo actualizar la contraseña.';
        header("Location: ../../index.php?vista=editarPerfil");
        exit();
    }

    $seActualizoContrasenia = true;
}

// Mensaje final en base a lo que realmente se actualizo
if ($seActualizoDatos && $seActualizoContrasenia) {
    $_SESSION['exito'] = 'Perfil y contraseña actualizados correctamente.';
} elseif ($seActualizoDatos) {
    $_SESSION['exito'] = 'Datos del perfil actualizados correctamente.';
} elseif ($seActualizoContrasenia) {
    $_SESSION['exito'] = 'Contraseña actualizada correctamente.';
} else {
    $_SESSION['error'] = 'No se pudo guardar ningun cambio.';
}

header("Location: ../../index.php?vista=editarPerfil");
exit();
