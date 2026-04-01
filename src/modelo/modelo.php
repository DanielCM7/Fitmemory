<?php

// CLASE PARA MANEJAR CONEXIONES CON LA BASE DE DATOS
class BaseDatos {
    // Creamos una propiedad estatica de conexion que por defecto sera null
    private static $conexion = null;

    // Crearemos un metodo estatico de acceso a base de datos
    private static function conexionBD() {
        // Cargamos el fichero de configuracion en una variable
        $config = parse_ini_file(__DIR__ . DIRECTORY_SEPARATOR . "config.ini");

        // Si la propiedad de conexion es null
        if (self::$conexion === null) {
            // Damos a la variable de conexion el valor de un objeto mysqli
            self::$conexion = new mysqli($config['server'], $config['user'], $config['pasw'], $config['bd']);

            // Indicamos que en el caso de que el objeto mysqli de error pare la aplicacion
            if (self::$conexion->connect_error) {
                die("Error en la conexion: " . self::$conexion->connect_error);
            }

            // Configuramos el codigo de caracteres a usar
            self::$conexion->set_charset('utf8mb4');
        }

        return self::$conexion;
    }

    // Metodo para cerrar la conexion a la base de datos y que no quede abierta
    public static function cerrarBD() {
        if (self::$conexion !== null) {
            self::$conexion->close();
            self::$conexion = null;
        }
    }

    // Funcion para automatizar el parametro inicial de bind_param
    private static function preparar($conexion, $consulta, ...$parametros) {
        $preparacion = $conexion->prepare($consulta);

        if ($parametros) {
            $tipos = '';

            foreach ($parametros as $parametro) {
                $tipos .= is_int($parametro) ? 'i' : 's';
            }

            $preparacion->bind_param($tipos, ...$parametros);
        }

        return $preparacion;
    }

    // Metodo para inserciones y actualizaciones
    public static function consultaInsercion($consulta, ...$parametros) {
        $conexion = self::conexionBD();
        $preparacion = self::preparar($conexion, $consulta, ...$parametros);
        return $preparacion->execute();
    }

    // Metodo para inserciones que necesitan devolver el id generado
    public static function consultaInsercionId($consulta, ...$parametros) {
        $conexion = self::conexionBD();
        $preparacion = self::preparar($conexion, $consulta, ...$parametros);

        if ($preparacion->execute()) {
            return $conexion->insert_id;
        }

        return false;
    }

    // Metodo para lecturas en la base de datos
    public static function consultaLectura($consulta, ...$parametros) {
        $conexion = self::conexionBD();
        $preparacion = self::preparar($conexion, $consulta, ...$parametros);
        $preparacion->execute();
        $resultado = $preparacion->get_result();

        if ($resultado->num_rows > 0) {
            return $resultado->fetch_all(MYSQLI_ASSOC);
        }

        return null;
    }

    // Metodos de apoyo para transacciones
    public static function iniciarTransaccion() {
        return self::conexionBD()->begin_transaction();
    }

    public static function confirmarTransaccion() {
        return self::conexionBD()->commit();
    }

    public static function deshacerTransaccion() {
        return self::conexionBD()->rollback();
    }
}
