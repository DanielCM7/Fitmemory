<?php

// Introducimos el modelo para poder usar la clase que maneja la base de datos SQL
require_once (__DIR__.'/../modelo/modelo.php');

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

// IMPORTANTE
// Función con un switch que enruta a una vista u otra
function enrute() {
    // En una variable 'rol' comprobarmos el perfil de usuario guardado en la variable de sesión 'perfil'. Si no hay ninguno el rol es 'invitado'. Usaremos esto para restringir el paso a rutas manualmente desde la barra de navegador y aportar seguridad.
    $rol = $_SESSION['perfil'] ?? 'invitado';
    // Si la variable pública 'vista' ya tiene un valor asociado, usaremos un condicional de tipo switch
    // De esta forma todas las páginas se visualizarán desde el index
    if (isset($_GET['vista'])) {

        // Guardamos el valor de vista
        $vista = $_GET['vista'];

        // Haremos un array que relaciones vistas con roles
        $permisos = [
            'administrador' => ['adminDashboard'],
            'cliente' => ['clienteDashboard', 'crearSesionEntreno', 'misSesiones', 'miProgreso'],
            'entrenador'  => ['entrenadorDashboard'],
            'invitado' => ['inicio', 'crearUsuario']
        ];

        // Si el rol no tiene permiso, forzamos al inicio o dashboard correspondiente
        if (!in_array($vista, $permisos[$rol] ?? [])) {
            if ($rol === 'administrador') $vista = 'adminDashboard';
            elseif ($rol === 'cliente') $vista = 'clienteDashboard';
            elseif ($rol === 'entrenador') $vista = 'entrenadorDashboard';
            else $vista = 'inicio';
        }

        switch ($vista) {
            // VISTAS ADMINISTRADOR _________________________________________________________________
            // Si el valor de 'vista' es 'adminDashboard'
            case 'adminDashboard':
                // Introducimos la vista del dashboard del administrador
                include_once "src/vista/adminDashboard.php";
                break;
            // VISTAS CLIENTE ______________________________________________________________________
            case 'clienteDashboard':
                // Introducimos la vista del dashboard del alumno a través de la clase controlador
                include_once "src/vista/clienteDashboard.php";
                break;
            case 'crearSesionEntreno':
                // Introducimos la vista del formulario de creación de sesión de entrenamiento
                include_once "src/vista/crearSesionEntreno.php";
                break;
            case 'misSesiones':
                // Introducimos la vista del formulario de creación de sesión de entrenamiento
                include_once "src/vista/misSesiones.php";
                break;
            case 'miProgreso':
                // Introducimos la vista del formulario de creación de sesión de entrenamiento
                include_once "src/vista/miProgreso.php";
                break;
            // VISTAS ENTRENADOR ___________________________________________________________________
            case 'entrenadorDashboard':
                // Introducimos la vista del dashboard del profesor
                include_once "src/vista/entrenadorDashboard.php";
                break;
            // VISTAS GENERALES ___________________________________________________________________
            // Si el valor de 'vista' es 'inicio'
            case 'inicio':
                // Redirigimos al formulario de inicio
                include_once "src/vista/loginInicio.php";
                break;
            // Como valor por defecto
            case 'crearUsuario':
                // Redirigimos al formulario de inicio
                include_once "src/vista/crearUsuario.php";
                break;
            // Como valor por defecto
            default:
                // Redirigimos al formulario de inicio
                //TODO: Crear página 404 para que sea default si hay algún error
                include_once "src/vista/loginInicio.php";
                break;
        }
    }
}


// Clase estática para realizar CRUD de la base de datos en la tabla de usuarios
// TODO Ahora mismo la tabla carece de nombre de usuario o email que sea ÚNICO que diferencia a usuarios con el mismo nombre, otra opción es que el usuario entre con su id.

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

// MÉTODOS GET __________________________________________________

    // TABLA ROLES _____________________________________________

    // Conseguir el id de un rol por el nombre del rol (cliente => 1)
    public static function getRolIdPorNombreRol ($nombre_rol) {
        $rol = ControladorBD::existeRolNombre($nombre_rol);
        if (is_null($rol)){
            return null;
        } else {
            return $rol['id_rol'];
        }
    }

    // Averiguar rol usuario a través de un id_rol (1 => cliente)
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

//MÉTODOS DE MODIFICACIÓN ______________________________________________

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
