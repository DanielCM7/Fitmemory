<?php

if (!defined('BASE_URL')) {
    define('BASE_URL', '/Fitmemory/');
}

require_once __DIR__ . '/controlador_BD.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario'])) {
    header("Location: " . BASE_URL . "index.php?vista=inicio");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: " . BASE_URL . "index.php?vista=crearSesionEntreno");
    exit();
}

$fecha = trim($_POST['fecha'] ?? '');
$comentario = trim($_POST['comentario'] ?? '');
$grupos = $_POST['grupo_id'] ?? [];
$ejercicios = $_POST['ejercicio_id'] ?? [];
$pesos = $_POST['peso'] ?? [];
$repeticiones = $_POST['repeticiones'] ?? [];
$series = $_POST['series'] ?? [];
$descansos = $_POST['descanso'] ?? [];
$rpes = $_POST['rpe'] ?? [];

$numeroFilas = count($ejercicios);

if (
    empty($fecha) ||
    $numeroFilas === 0 ||
    count($grupos) !== $numeroFilas ||
    count($pesos) !== $numeroFilas ||
    count($repeticiones) !== $numeroFilas ||
    count($series) !== $numeroFilas ||
    count($descansos) !== $numeroFilas ||
    count($rpes) !== $numeroFilas
) {
    $_SESSION['error'] = 'La sesion no se pudo guardar porque faltan datos del formulario.';
    header("Location: " . BASE_URL . "index.php?vista=crearSesionEntreno");
    exit();
}

$marcaTiempoFecha = strtotime($fecha . ' 00:00:00');

if ($marcaTiempoFecha === false) {
    $_SESSION['error'] = 'La fecha de la sesion no es valida.';
    header("Location: " . BASE_URL . "index.php?vista=crearSesionEntreno");
    exit();
}

$fechaNormalizada = date('Y-m-d H:i:s', $marcaTiempoFecha);
$ejerciciosSesion = [];

for ($i = 0; $i < $numeroFilas; $i++) {
    $idGrupo = filter_var($grupos[$i], FILTER_VALIDATE_INT);
    $idEjercicio = filter_var($ejercicios[$i], FILTER_VALIDATE_INT);
    $peso = filter_var($pesos[$i], FILTER_VALIDATE_FLOAT);
    $reps = filter_var($repeticiones[$i], FILTER_VALIDATE_INT);
    $numSeries = filter_var($series[$i], FILTER_VALIDATE_INT);
    $descanso = filter_var($descansos[$i], FILTER_VALIDATE_INT);
    $rpe = filter_var($rpes[$i], FILTER_VALIDATE_INT);

    if (
        $idGrupo === false ||
        $idEjercicio === false ||
        $peso === false ||
        $reps === false ||
        $numSeries === false ||
        $descanso === false ||
        $rpe === false ||
        $peso < 0 ||
        $reps < 1 ||
        $numSeries < 1 ||
        $descanso < 0 ||
        $rpe < 0 ||
        $rpe > 10
    ) {
        $_SESSION['error'] = 'Revisa los ejercicios de la sesion: hay valores no validos.';
        header("Location: " . BASE_URL . "index.php?vista=crearSesionEntreno");
        exit();
    }

    $ejerciciosSesion[] = [
        'id_grupo' => $idGrupo,
        'id_ejercicio' => $idEjercicio,
        'peso' => number_format((float)$peso, 2, '.', ''),
        'repeticiones' => $reps,
        'series' => $numSeries,
        'descanso' => $descanso,
        'rpe' => $rpe
    ];
}

$idSesion = ControladorBD::crearSesionEntreno(
    (int)$_SESSION['id_usuario'],
    $fechaNormalizada,
    $comentario,
    $ejerciciosSesion
);

if ($idSesion === false) {
    $_SESSION['error'] = 'No se pudo guardar la sesion de entreno.';
    header("Location: " . BASE_URL . "index.php?vista=crearSesionEntreno");
    exit();
}

$_SESSION['exito'] = 'Sesion guardada correctamente.';
$_SESSION['ultima_sesion_creada'] = $idSesion;
header("Location: " . BASE_URL . "index.php?vista=sesionCreada&id_sesion=" . $idSesion);
exit();
