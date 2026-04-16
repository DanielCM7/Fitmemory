<?php

require_once "cierre_funciones.php";

//Si cierra correctamente, redirige a la página de inicio de sesión con mensaje de éxito

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../../index.php");
    exit();

}

cierreAnalogicoConMensaje();
