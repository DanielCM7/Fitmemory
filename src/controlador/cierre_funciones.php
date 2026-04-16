<?php

// Vamos a crear una función que encapsule el cierre analógico
function cierreAnalogico()
{
    // Función de iniciar sesión
    session_start();
    // Eliminamos datos de la sesión en el lado cliente
    session_unset();
    // Eliminamos datos de la sesión en el lado servidor
    session_destroy();
    // Redirigir al usuario al index
    header("Location: ../../index.php?vista=inicio");
    exit();
}

function cierreAnalogicoConMensaje()
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    // Eliminamos datos de la sesión en el lado cliente
    session_unset();
    // Eliminamos datos de la sesión en el lado servidor
    session_destroy();
    // Guardar un mensaje de cierre de sesión en una variable de sesión temporal
    session_start();
    $_SESSION['exito'] = "Sesion cerrada correctamente.";
    // Redirigir al usuario al index con mensaje de cierre de sesión
    header("Location: ../../index.php?vista=inicio&mensaje=cierre");
    exit();
}

// Vamos a crear un cierre programado a los 30 minutos
// TODO: Revisar como hacía para que no se cerrase si hay actividad. Ahora mismo se cierra incluso si hay actividad.
function cierreProgramado()
{
    // Usamos la función inicializa la sesión, usamos un if que evite un NOTICE en XAMPP
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    //Control de tiempo a la sesion
    // Establece el tiempo máximo de vida de la sesión (30 minutos en segundos)
    $tiempo_maximo = 30 * 60; // 30 minutos

    // Comprobamos si hay sesión con tiempo establecido y si ha superado el máximo
    if (isset($_SESSION['tiempo'])) {
        if ((time() - $_SESSION['tiempo']) > $tiempo_maximo) {
            session_unset();
            session_destroy();
            header("Location: index.php?vista=inicio");
            exit();
        }
    }
}
