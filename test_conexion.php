<?php

// ESTO ES UNA PRUEBA DE QUE LA CONEXIÓN A LA BBDD FUNCIONE
// Para probar ir al navegador a http://localhost/Fitmemory/test_conexion.php
$config = parse_ini_file("src/modelo/config.ini");

$conexion = new mysqli($config['server'], $config['user'], $config['pasw'], $config['bd']);


if ($conexion->connect_error) {
    echo "Error de conexión: " . $conexion->connect_error;
} else {
    echo "Conexión correcta a la base de datos";
}

?>