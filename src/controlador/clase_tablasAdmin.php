<?php

class GeneradorTablasAdmin {

    // Función que genera un listado en forma de tabla para los usuarios en el dashboard de admin
    // Pasamos como parámetro una variable $usuarios que debe contener el listado de usuarios de la BD
    public static function tablaUsuarios($usuarios) {
    // Variable que concatenará el HTML para devolver la tabla en una sola variable
    $tablaUsuarios = "";
    // Títulos de columna
    $tablaUsuarios .= <<<HTML
        <table id="tabla" class="table table-dark table-striped align-middle mb-0">
        <tr>
            <th id="bt-id">id_usuario</th>
            <th id="bt-nombre" style="cursor:pointer">nombre_usuario</th>
            <th>rol</th>
            <th>nombre</th>
            <th>apellidos</th>
            <th>fecha_nacimiento</th>
            <th>contrasena_hash</th>
            <th>fecha_registro</th>
            <th>EDITAR</th>
            <th>BORRAR</th>
        </tr>
    HTML;
    // Se comprueba que el parámetro $usuarios introducido no está vacío
    if(isset($usuarios)) {
        // Leemos cada posición del array y usando clave-valor guardamos en una variable cada campo de la tabla
        foreach ($usuarios as $usuario) {
            $id_usuario = $usuario['id_usuario'];
            $nombre_usuario = $usuario['nombre_usuario'];
            $rol = ControladorBD::getRolUsuarioPorId($usuario['id_rol']);
            $nombre = $usuario['nombre'];
            $apellidos = $usuario['apellidos'];
            $fecha_nacimiento = $usuario['fecha_nacimiento'];
            $contrasena_hash = $usuario['contrasena_hash'];
            $fecha_registro = $usuario['fecha_registro'];
            // Concatenamos una fila de la tabla con los datos anteriores, cada uno en su columna correspondiente
            $tablaUsuarios .= <<<HTML
                <tr style="display:table-row">
                <td>$id_usuario</td>
                <td>$nombre_usuario</td>
                <td>$rol</td>
                <td>$nombre</td>
                <td>$apellidos</td>
                <td>$fecha_nacimiento</td>
                <td>••••••</td>
                <td>$fecha_registro</td>
                <!-- Aquí generamos por cada usuario/fila un botón para actualizar ese usuario-->
                <td>
                    <!-- Creamos un formulario invisible que recoja los datos del usuario en la fila, para tenerlos guardados en el formulario de actualización -->
                    <form class="hidden-form" method="POST">
                    <input type="hidden" name="id_usuario" value="$id_usuario">
                    <input type="hidden" name="nombre_usuario" value="$nombre_usuario">
                    <input type="hidden" name="rol" value="$rol">
                    <input type="hidden" name="nombre" value="$nombre">
                    <input type="hidden" name="apellidos" value="$apellidos">
                    <input type="hidden" name="fecha_nacimiento" value="$fecha_nacimiento">
                    <input type="hidden" name="contrasena_hash" value="$contrasena_hash">
                    <input type="hidden" name="fecha_registro" value="$fecha_registro">
                    <!-- Al hacer click en el botón se envían los datos del formulario, se va a una página de actualización-->
                    <button type="submit" class="btn btn-outline-light btn-sm d-flex align-items-center gap-2 topbar-boton topbar-boton-ancho" formaction="index.php?vista=adminActualizarUsuario" style="min-width:fit-content">
                        <i class="bi bi-pencil-square"></i>
                    </button>
                    </form>
                </td>
                <!-- Aquí generamos por cada usuario/fila un botón para eliminarlo -->
                <td>
                    <!-- Creamos un formulario que refresque la página enviando datos que permitan realizar la acción de eliminar al usuario en esa fila -->
                    <form class="hidden-form" method="POST">
                    <input type="hidden" name="accion" value="eliminar">
                    <input type="hidden" name="id_usuario" value="$id_usuario">
                    <!-- Al hacer click en el botón se envían los datos del formulario, se recarga la página y se procesan -->
                    <button type="submit" class="btn btn-outline-light btn-sm d-flex align-items-center gap-2 topbar-boton topbar-boton-ancho" onclick="window.location.reload();" style="min-width:fit-content">
                        <i class="bi bi-trash"></i>
                    </button>
                    </form>
                </td>
                </tr>
            HTML;
        }
    }
    $tablaUsuarios .= "</table>";
    return $tablaUsuarios;
    }

}