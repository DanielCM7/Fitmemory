<?php

// Introducimos el modelo para poder usar la clase que maneja la base de datos SQL
require_once(__DIR__ . '/../modelo/modelo.php');

// CLASE PARA HACER CRUD EN LA BASE DE DATOS
class ControladorBD
{
    // COMPROBAR QUE EXISTE __________________________________________________

    // TABLA USUARIOS _________________________________________________

    // Metodo para buscar un usuario en base a su nombre de usuario
    public static function existeUsuario($nombre_usuario)
    {
        $consulta = "SELECT * FROM usuarios WHERE nombre_usuario = ?";
        $resultado = BaseDatos::consultaLectura($consulta, $nombre_usuario);
        return $resultado ? $resultado[0] : null;
    }

    // TABLA ROLES _________________________________________________

    // Comprobar que existe un rol a traves del id
    public static function existeRolId($id_rol)
    {
        $consulta = "SELECT * FROM roles WHERE id_rol = ?";
        $resultado = BaseDatos::consultaLectura($consulta, $id_rol);
        return $resultado ? $resultado[0] : null;
    }

    // Comprobar que existe un rol a traves del nombre
    public static function existeRolNombre($nombre_rol)
    {
        $consulta = "SELECT * FROM roles WHERE nombre_rol = ?";
        $resultado = BaseDatos::consultaLectura($consulta, $nombre_rol);
        return $resultado ? $resultado[0] : null;
    }

    // METODOS GET (OBTENER DATOS A PARTIR DE UNO CONOCIDO) ______________________

    // TABLA ROLES _____________________________________________

    // Conseguir el id de un rol por el nombre del rol
    public static function getRolIdPorNombreRol($nombre_rol)
    {
        $rol = ControladorBD::existeRolNombre($nombre_rol);
        if (is_null($rol)) {
            return null;
        } else {
            return $rol['id_rol'];
        }
    }

    // Averiguar rol usuario a traves de un id_rol
    public static function getRolUsuarioPorId($id_rol)
    {
        $rol = ControladorBD::existeRolId($id_rol);
        if (is_null($rol)) {
            return null;
        } else {
            return $rol['nombre_rol'];
        }
    }

    // Averiguar rol de un usuario a traves de su nombre
    public static function getRolUsuarioPorUsuario($nombre_usuario)
    {
        $usuario = ControladorBD::existeUsuario($nombre_usuario);
        if (is_null($usuario)) {
            return null;
        } else {
            $nombre_rol = ControladorBD::getRolUsuarioPorId($usuario['id_rol']);
            return $nombre_rol;
        }
    }

    // TABLA USUARIOS _____________________________________________

    // Metodo para obtener directamente el nombre de pila de un usuario en base a un usuario
    public static function getNombrePilaUser($nombre_usuario)
    {
        $usuario = ControladorBD::existeUsuario($nombre_usuario);
        return $usuario ? $usuario['nombre'] : null;
    }

    // Metodo para obtener directamente los apellidos de un usuario en base a un usuario
    public static function getApellidosUser($nombre_usuario)
    {
        $usuario = ControladorBD::existeUsuario($nombre_usuario);
        return $usuario ? $usuario['apellidos'] : null;
    }

    // IMPORTANTE: Metodo para comprobar las credenciales de un login
    public static function loginUsuario($nombre_usuario, $contrasena_hash)
    {
        $consulta = "SELECT * FROM usuarios WHERE nombre_usuario = ? AND contrasena_hash = ?";
        $resultado = BaseDatos::consultaLectura($consulta, $nombre_usuario, hash('sha256', $contrasena_hash));
        return $resultado ? $resultado[0] : null;
    }

    //METODOS PARA USUARIOS

    // METODOS DE CREACION _____________________________________________________

    // CREACION DE USUARIOS ______________________________________________

    // Metodo de insercion para crear un nuevo registro en la tabla usuario
    public static function crearUsuario($nombre_usuario, $contrasena_hash, $nombre, $apellidos, $id_rol, $fecha_nacimiento)
    {
        $consulta = "INSERT INTO usuarios (nombre_usuario, contrasena_hash, nombre, apellidos, id_rol, fecha_nacimiento) VALUES (?, ?, ?, ?, ?, ?)";
        return BaseDatos::consultaInsercion($consulta, $nombre_usuario, hash('sha256', $contrasena_hash), $nombre, $apellidos, $id_rol, $fecha_nacimiento);
    }

    //METODOS DE LECTURA _____________________________________________________
    // Metodo para obtener un usuario por su id

    public static function obtenerUsuarioPorId($id_usuario)
    {
        $consulta = "SELECT id_usuario, nombre_usuario, nombre, apellidos, fecha_nacimiento, email
                 FROM usuarios
                 WHERE id_usuario = ? AND activo = 1";
        $resultado = BaseDatos::consultaLectura($consulta, (int)$id_usuario);
        return $resultado ? $resultado[0] : null;
    }


    // METODOS DE MODIFICACION/ACTUALIZACION ____________________________________

    // CAMBIAR TU CONTRASENA COMO USUARIO

    public static function cambiarContrasena($nombre_usuario, $contrasena_hash)
    {
        $consulta = "UPDATE usuarios SET contrasena_hash = ? WHERE nombre_usuario = ?";
        return BaseDatos::consultaInsercion($consulta, hash('sha256', $contrasena_hash), $nombre_usuario);
    }

    public static function actualizarPerfilUsuario($id_usuario, $nombre, $apellidos, $fecha_nacimiento, $correoElec)
    {
        $consulta = "UPDATE usuarios
                 SET nombre = ?, apellidos = ?, fecha_nacimiento = ?, email = ?
                 WHERE id_usuario = ? AND activo = 1";
        return BaseDatos::consultaInsercion(
            $consulta,
            trim($nombre),
            trim($apellidos),
            $fecha_nacimiento,
            trim($correoElec),
            (int)$id_usuario
        );
    }

    // METODOS PARA CRUD DE ADMINISTRADORES EN PANEL DE USUARIOS ____________
    //DEJO COMENTADO ESTE METODO PORQUE NO SE SI LO VAMOS A USAR, PERO SI QUEREMOS QUE UN ADMIN PUEDA CAMBIAR EL ROL DE OTRO USUARIO, PUEDE SER UTIL. SI NO, LO BORRAMOS Y YA ESTA.

    /* public static function actualizarUsuario($id_usuario, $contrasena_hash, $nombre, $apellidos, $id_rol, $fecha_nacimiento) {
         $consulta = "UPDATE usuarios SET contrasena_hash = ?, nombre_completo = ?, id_rol = ? WHERE id_usuario = ?";
         return BaseDatos::consultaInsercion($consulta, hash('sha256', $contrasena_hash), $nombre, $apellidos, $id_rol, $fecha_nacimiento, $id_usuario);
     }
         */

    //METODOS DE ELIMINACION _____________________________________________________

    // Metodo de eliminar registros en la tabla usuario en base al id
    public static function eliminarUsuario($id_usuario)
    {
        $consulta = "DELETE FROM usuarios WHERE id_usuario = ?";
        return BaseDatos::consultaInsercion($consulta, $id_usuario);
    }

    // Metodo para listar TODOS los usuarios
    public static function listarUsuarios()
    {
        $consulta = "SELECT * FROM usuarios";
        $usuarios = BaseDatos::consultaLectura($consulta);
        return $usuarios ? $usuarios : null;
    }

    // METODOS PARA SESIONES DE ENTRENAMIENTO _______________________________

    public static function listarGruposMusculares()
    {
        $consulta = "SELECT id_grupo, nombre FROM grupos_musculares ORDER BY nombre ASC";
        $grupos = BaseDatos::consultaLectura($consulta);
        return $grupos ? $grupos : null;
    }

    public static function listarEjercicios()
    {
        $consulta = "SELECT id_ejercicio, id_grupo, nombre FROM ejercicios ORDER BY nombre ASC";
        $ejercicios = BaseDatos::consultaLectura($consulta);
        return $ejercicios ? $ejercicios : null;
    }

    public static function listarEjerciciosPorGrupo()
    {
        $ejercicios = self::listarEjercicios() ?? [];
        $ejerciciosPorGrupo = [];

        foreach ($ejercicios as $ejercicio) {
            $idGrupo = (string)$ejercicio['id_grupo'];

            if (!isset($ejerciciosPorGrupo[$idGrupo])) {
                $ejerciciosPorGrupo[$idGrupo] = [];
            }

            $ejerciciosPorGrupo[$idGrupo][] = [
                'id' => (int)$ejercicio['id_ejercicio'],
                'nombre' => $ejercicio['nombre']
            ];
        }

        return $ejerciciosPorGrupo;
    }

    public static function obtenerEjercicioPorId($id_ejercicio)
    {
        $consulta = "SELECT e.id_ejercicio, e.id_grupo, e.nombre, gm.nombre AS grupo_nombre
                    FROM ejercicios e
                    INNER JOIN grupos_musculares gm ON gm.id_grupo = e.id_grupo
                    WHERE e.id_ejercicio = ?";
        $resultado = BaseDatos::consultaLectura($consulta, $id_ejercicio);
        return $resultado ? $resultado[0] : null;
    }

    public static function crearSesionEntreno($id_usuario, $fecha, $comentario, $ejercicios)
    {
        BaseDatos::iniciarTransaccion();

        try {
            $id_sesion = BaseDatos::consultaInsercionId(
                "INSERT INTO sesiones (id_usuario, fecha, comentario) VALUES (?, ?, ?)",
                $id_usuario,
                $fecha,
                $comentario
            );

            if ($id_sesion === false) {
                throw new Exception("No se pudo crear la sesion");
            }

            foreach ($ejercicios as $ejercicio) {
                $ejercicioBD = self::obtenerEjercicioPorId($ejercicio['id_ejercicio']);

                if (is_null($ejercicioBD)) {
                    throw new Exception("El ejercicio seleccionado no existe");
                }

                if ((int)$ejercicio['id_grupo'] !== (int)$ejercicioBD['id_grupo']) {
                    throw new Exception("El ejercicio no pertenece al grupo muscular indicado");
                }

                for ($numeroSerie = 1; $numeroSerie <= (int)$ejercicio['series']; $numeroSerie++) {
                    $ok = BaseDatos::consultaInsercion(
                        "INSERT INTO sesiones_ejercicios (
                            id_sesion,
                            id_ejercicio,
                            num_serie,
                            repeticion_real,
                            peso_real,
                            descanso_real,
                            rpe
                        ) VALUES (?, ?, ?, ?, ?, ?, ?)",
                        $id_sesion,
                        (int)$ejercicio['id_ejercicio'],
                        $numeroSerie,
                        (int)$ejercicio['repeticiones'],
                        $ejercicio['peso'],
                        (int)$ejercicio['descanso'],
                        (int)$ejercicio['rpe']
                    );

                    if (!$ok) {
                        throw new Exception("No se pudieron guardar las series del ejercicio");
                    }
                }
            }

            BaseDatos::confirmarTransaccion();
            return $id_sesion;
        } catch (Throwable $e) {
            BaseDatos::deshacerTransaccion();
            return false;
        }
    }

    public static function listarSesionesPorUsuario($id_usuario)
    {
        $consulta = "SELECT
                        s.id_sesion,
                        s.fecha,
                        s.comentario,
                        e.nombre AS ejercicio_nombre,
                        gm.nombre AS grupo_nombre,
                        se.num_serie,
                        se.repeticion_real,
                        se.peso_real,
                        se.descanso_real,
                        se.rpe
                    FROM sesiones s
                    LEFT JOIN sesiones_ejercicios se ON se.id_sesion = s.id_sesion
                    LEFT JOIN ejercicios e ON e.id_ejercicio = se.id_ejercicio
                    LEFT JOIN grupos_musculares gm ON gm.id_grupo = e.id_grupo
                    WHERE s.id_usuario = ?
                    ORDER BY s.fecha DESC, s.id_sesion DESC, e.nombre ASC, se.num_serie ASC";
        $sesiones = BaseDatos::consultaLectura($consulta, $id_usuario);
        return $sesiones ? $sesiones : null;
    }

    public static function obtenerSesionesAgrupadasPorUsuario($id_usuario)
    {
        $registrosSesiones = self::listarSesionesPorUsuario($id_usuario) ?? [];
        $sesionesAgrupadas = [];

        foreach ($registrosSesiones as $registro) {
            $idSesion = (int)$registro['id_sesion'];

            if (!isset($sesionesAgrupadas[$idSesion])) {
                $sesionesAgrupadas[$idSesion] = [
                    'fecha' => $registro['fecha'],
                    'comentario' => $registro['comentario'],
                    'ejercicios' => []
                ];
            }

            if (!is_null($registro['ejercicio_nombre'])) {
                $sesionesAgrupadas[$idSesion]['ejercicios'][] = $registro;
            }
        }

        return $sesionesAgrupadas;
    }

    public static function obtenerSesionPorIdUsuario($id_sesion, $id_usuario)
    {
        $consulta = "SELECT id_sesion, fecha, comentario
                    FROM sesiones
                    WHERE id_sesion = ? AND id_usuario = ?";
        $resultado = BaseDatos::consultaLectura($consulta, $id_sesion, $id_usuario);
        return $resultado ? $resultado[0] : null;
    }

    public static function listarResumenEjerciciosSesion($id_sesion, $id_usuario)
    {
        $consulta = "SELECT
                        e.nombre AS ejercicio_nombre,
                        gm.nombre AS grupo_nombre,
                        COUNT(se.id_sesion_ejercicio) AS series,
                        MAX(se.repeticion_real) AS repeticiones,
                        MAX(se.peso_real) AS peso,
                        MAX(se.descanso_real) AS descanso,
                        MIN(se.id_sesion_ejercicio) AS orden_visual
                    FROM sesiones s
                    INNER JOIN sesiones_ejercicios se ON se.id_sesion = s.id_sesion
                    INNER JOIN ejercicios e ON e.id_ejercicio = se.id_ejercicio
                    INNER JOIN grupos_musculares gm ON gm.id_grupo = e.id_grupo
                    WHERE s.id_sesion = ? AND s.id_usuario = ?
                    GROUP BY e.id_ejercicio, e.nombre, gm.nombre
                    ORDER BY orden_visual ASC";
        $ejercicios = BaseDatos::consultaLectura($consulta, $id_sesion, $id_usuario);
        return $ejercicios ? $ejercicios : [];
    }

    public static function obtenerDetalleSesionPorIdUsuario($id_sesion, $id_usuario)
    {
        $sesion = self::obtenerSesionPorIdUsuario($id_sesion, $id_usuario);

        if (is_null($sesion)) {
            return null;
        }

        return [
            'sesion' => $sesion,
            'ejercicios' => self::listarResumenEjerciciosSesion($id_sesion, $id_usuario)
        ];
    }
}
