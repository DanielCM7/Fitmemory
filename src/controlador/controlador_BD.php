<?php

// Introducimos el modelo para poder usar la clase que maneja la base de datos SQL
require_once (__DIR__.'/../modelo/modelo.php');

// CLASE PARA HACR CRUD EN LA BASE DE DATOS
class ControladorBD {

// COMPROBAR QUE EXISTE __________________________________________________

    // TABLA USUARIOS _________________________________________________

    // Método para buscar un usuario en base a su nombre de usuario
    public static function existeUsuario ($nombre_usuario) {
        // Seleccionamos todos los registros con ese nombre de usuario. Al ser un campo único debe existir 1 o 0.
        $consulta ="SELECT * FROM usuarios WHERE nombre_usuario = ?";
        // Se introduce la lectura de la consulta en una variable
        $resultado = BaseDatos::consultaLectura ($consulta, $nombre_usuario);
        // Si existe resultado y no está vacía se devuelve la primera posición (y única) del array en el que se guarda
        return $resultado ? $resultado[0] : null;
    }

    // TABLA ROLES _________________________________________________

    // Comprobar que existe un rol a través del id
    public static function existeRolId ($id_rol) {
        // Seleccionamos todos los registros con ese nombre de usuario. Al ser un campo único debe existir 1 o 0.
        $consulta ="SELECT * FROM roles WHERE id_rol = ?";
        // Se introduce la lectura de la consulta en una variable
        $resultado = BaseDatos::consultaLectura ($consulta, $id_rol);
        // Si existe resultado y no está vacía se devuelve la primera posición (y única) del array en el que se guarda
        return $resultado ? $resultado[0] : null;
    }

    // Comprobar que existe un rol a través del nombre
    public static function existeRolNombre ($nombre_rol) {
        // Seleccionamos todos los registros con ese nombre de usuario. Al ser un campo único debe existir 1 o 0.
        $consulta ="SELECT * FROM roles WHERE nombre_rol = ?";
        // Se introduce la lectura de la consulta en una variable
        $resultado = BaseDatos::consultaLectura ($consulta, $nombre_rol);
        // Si existe resultado y no está vacía se devuelve la primera posición (y única) del array en el que se guarda
        return $resultado ? $resultado[0] : null;
    }

// MÉTODOS GET (OBTENER DATOS A PARTIR DE UNO CONOCIDO) ____________________________________________

    // TABLA ROLES _____________________________________________

    // Conseguir el id de un rol por el nombre del rol (cliente devuelve 1)
    public static function getRolIdPorNombreRol ($nombre_rol) {
        $rol = ControladorBD::existeRolNombre($nombre_rol);
        if (is_null($rol)){
            return null;
        } else {
            return $rol['id_rol'];
        }
    }
    // Averiguar rol usuario a través de un id_rol (1 devuelve cliente)
    public static function getRolUsuarioPorId($id_rol) {
        $rol = ControladorBD::existeRolId($id_rol);
        if (is_null($rol)){
            return null;
        } else {
            return $rol['nombre_rol'];
        }
    }
    // Averiguar rol de un usuario a través de su nombre (usuario => 1 => cliente)
    public static function getRolUsuarioPorUsuario($nombre_usuario) {
        $usuario = ControladorBD::existeUsuario($nombre_usuario);
        if (is_null($usuario)){
            return null;
        } else {
            $nombre_rol = ControladorBD::getRolUsuarioPorId($usuario['id_rol']);
            return $nombre_rol;
        }
    }

    // TABLA USUARIOS _____________________________________________

    // Método para obtener directamente el nombre de pila de un usuario en base a un usuario
    public static function getNombrePilaUser ($nombre_usuario) {
        $usuario = ControladorBD::existeUsuario($nombre_usuario);
        // Si existe el usuario devolvemos el valor del campo nombre
        return $usuario ? $usuario['nombre'] : null;
    }
    // Método para obtener directamente los apellidos de un usuario en base a un usuario
    public static function getApellidosUser ($nombre_usuario) {
        $usuario = ControladorBD::existeUsuario($nombre_usuario);
        // Si existe el usuario devolvemos el valor del campo nombre
        return $usuario ? $usuario['apellidos'] : null;
    }
    // IMPORTANTE: Método para comprobar las credenciales de un login
    public static function loginUsuario($nombre_usuario, $contrasena_hash) {
        // Comprobamos que exista un usuario y que su contraseña sea exactamente la introducida
        $consulta ="SELECT * FROM usuarios WHERE nombre_usuario = ? AND contrasena_hash = ?";
        // Se introduce el resultado de la consulta
        // Integramos el 'hasheado' de la variable contraseña para que la comparación de lectura funcione correctamente
        $resultado = BaseDatos::consultaLectura ($consulta, $nombre_usuario, hash('sha256', $contrasena_hash));
        // Si existe un registro coincidente y no está vacía devolvemos la primera posción (y única) del array que se genera
        return $resultado ? $resultado[0] : null;
    }

// MÉTODOS DE CREACIÓN _____________________________________________________

    // CREACIÓN DE USUARIOS ______________________________________________

    // Método de inserción para crear un nuevo registro en la tabla usuario (TANTO PARA ADMIN COMO CREAR NUEVO USUARIO DESDE INICIO)
    public static function crearUsuario($nombre_usuario, $contrasena_hash, $nombre, $apellidos, $id_rol, $fecha_nacimiento) {
        // Insertaremos todos los datos de la tabla menos aquellos como el nº de usuario y fecha que son automáticos
        $consulta ="INSERT INTO usuarios (nombre_usuario, contrasena_hash, nombre, apellidos, id_rol, fecha_nacimiento) VALUES (?, ?, ?, ?, ?, ?)";
        // Usamos el método de inserción en vez de el de lectura
        // Integramos el 'hasheado' de la variable contraseña para que se escriba en la base de datos con esta codificación
        return BaseDatos::consultaInsercion($consulta, $nombre_usuario, hash('sha256', $contrasena_hash), $nombre, $apellidos, $id_rol, $fecha_nacimiento);
    }

//MÉTODOS DE MODIFICACIÓN/ACTUALIZACIÓN ______________________________________________

    // CAMBIAR TU CONTRASEÑA COMO USUARIO
    // Metodo de actualización de datos (también de escritura en la BD)
    public static function cambiarContrasena($nombre_usuario, $contrasena_hash) {
        // En base al nombre de usuario (que es único) localizamos al usuario y modificamos algunos parámetros (otros previamente establecidos quedan igual)
        $consulta ="UPDATE usuarios SET contrasena_hash = ? WHERE nombre_usuario = ?";
        // Integramos el 'hasheado' de la variable contraseña para que se escriba en la base de datos con esta codificación
        return BaseDatos::consultaInsercion($consulta, hash('sha256', $contrasena_hash), $nombre_usuario);
    }

    // MÉTODOS PARA CRUD DE ADMINISTRADORES EN PANEL DE USUARIOS_______________________________________

    // Metodo de actualización de datos (también de escritura en la BD)
    public static function actualizarUsuario($id_usuario, $contrasena_hash, $nombre, $apellidos, $id_rol, $fecha_nacimiento) {
        // En base al id de usuario (que es único) localizamos al usuario y modificamos algunos parámetros (otros previamente establecidos quedan igual)
        $consulta ="UPDATE usuarios SET contrasena_hash = ?, nombre_completo = ?, id_rol = ? WHERE id_usuario = ?";
        // Integramos el 'hasheado' de la variable contraseña para que se escriba en la base de datos con esta codificación
        return BaseDatos::consultaInsercion($consulta, hash('sha256', $contrasena_hash), $nombre, $apellidos, $id_rol, $fecha_nacimiento, $id_usuario);
    }

    // Método de eliminar registros en la tabla usuario en base al id
    public static function eliminarUsuario ($id_usuario){
        $consulta = "DELETE FROM usuarios WHERE id_usuario = ?";
        return BaseDatos::consultaInsercion($consulta, $id_usuario);
    }
    // Método para listar TODOS los usuarios
    public static function listarUsuarios() {
        // Consultamos todos los registros de la tabla usuarios
        $consulta ="SELECT * FROM usuarios";
        // Introducimos en una variable la información obtenida de la lectura de la BD
        $usuarios = BaseDatos::consultaLectura($consulta);
        // Devolvemos los registros si existen, en forma de array
        return $usuarios ? $usuarios : null;
    }
}
?>
