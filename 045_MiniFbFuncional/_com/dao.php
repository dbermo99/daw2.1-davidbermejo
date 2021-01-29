<?php

require_once "clases.php";
require_once "_Varios.php";

class DAO
{
    private static $pdo = null;

    private static function obtenerPdoConexionBD()
    {
        $servidor = "localhost";
        $identificador = "root";
        $contrasenna = "";
        $bd = "minifb"; // Schema
        $opciones = [
            PDO::ATTR_EMULATE_PREPARES => false, // Modo emulación desactivado para prepared statements "reales"
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Que los errores salgan como excepciones.
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // El modo de fetch que queremos por defecto.
        ];

        try {
            $pdo = new PDO("mysql:host=$servidor;dbname=$bd;charset=utf8", $identificador, $contrasenna, $opciones);
        } catch (Exception $e) {
            error_log("Error al conectar: " . $e->getMessage());
            exit("Error al conectar" . $e->getMessage());
        }

        return $pdo;
    }

    private static function ejecutarConsulta(string $sql, array $parametros): array
    {
        if (!isset(self::$pdo)) self::$pdo = self::obtenerPdoConexionBd();

        $select = self::$pdo->prepare($sql);
        $select->execute($parametros);
        $rs = $select->fetchAll();

        return $rs;
    }

    private static function ejecutarActualizacion(string $sql, array $parametros): bool
    {
        if (!isset(self::$pdo)) self::$pdo = self::obtenerPdoConexionBd();

        $actualizacion = self::$pdo->prepare($sql);
        $sqlConExito = $actualizacion->execute($parametros);

        return $sqlConExito;
    }

    /* PUBLICACION */

    private static function publicacionCrearDesdeRs(array $fila): Publicacion
    {
        if(isset($fila["destacadaHasta"]) && $fila["destacadaHasta"] == null)
            $fila["destacadaHasta"] = "";
        return new Publicacion($fila["id"], $fila["fecha"], $fila["emisorId"], $fila["destinatarioId"], $fila["destacadoHasta"], $fila["asunto"], $fila["contenido"]);
    }

    public static function publicacionObtenerPorId(int $id): ?Publicacion
    {
        $rs = self::ejecutarConsulta(
            "SELECT * FROM Publicacion WHERE id=?",
            [$id]
        );
        if ($rs) return self::publicacionCrearDesdeRs($rs[0]);
        else return null;
    }

    public static function publicacionActualizar(int $id, string $fecha, int $emisorId, int $destinatarioId, string $destacadoHasta, string $asunto, string $contenido)
    {
        self::ejecutarActualizacion(
            "UPDATE Publicacion SET fecha=?, emisorId=?, destinatarioId=?, destacadaHasta=?, asunto=?, contenido=? WHERE id=?",
            [$fecha, $emisorId, $destinatarioId, $destacadoHasta, $asunto, $contenido, $id]
        );
    }

    public static function publicacionCrear(string $fecha, int $emisorId, $destinatarioId, string $destacadoHasta, string $asunto, string $contenido): bool
    {
        if($destacadoHasta == null)
            $destacadoHasta= "";
        return self::ejecutarActualizacion(
            "INSERT INTO Publicacion (fecha, emisorId, destinatarioId, destacadaHasta, asunto, contenido) VALUES (?, ?, ?, ?, ?, ?)",
            [$fecha, $emisorId, $destinatarioId, $destacadoHasta, $asunto, $contenido]
        );
    }

    public static function publicacionObtenerTodas($posibleClausulaWhere): array
    {
        $datos = [];
        $rs = self::ejecutarConsulta(
            "SELECT * FROM Publicacion $posibleClausulaWhere ORDER BY fecha DESC",
            []
        );

        foreach ($rs as $fila) {
            $publicacion = self::publicacionCrearDesdeRs($fila);
            array_push($datos, $publicacion);
        }

        return $datos;
    }
	public static function eliminarPublicacionPorId(int $id): bool
    {
        
        $sql = "DELETE FROM Publicacion WHERE id=?";

        return self::ejecutarActualizacion($sql, [$id]);
    }

    public static function publicacionGuardarPorId(int $id, string $fecha, int $emisorId, int $destinatarioId, string $destacadoHasta, string $asunto, string $contenido): bool
    {
        return self::ejecutarActualizacion(
            "UPDATE Publicacion SET fecha=?, emisorId=?, destinatarioId=?, destacadaHasta=?, asunto=?, contenido=? WHERE id=?",
            [$fecha, $emisorId, $destinatarioId, $destacadoHasta, $asunto, $contenido, $id]
        );
    }

    public static function publicacionFicha($id): array
    {
        $nuevaEntrada = ($id == -1);
	    if ($nuevaEntrada) {
            $fecha= "<introduzca fecha>";
            $emisorId= "<introduzca emisorId>";
            $destinatarioId = "<introduzca destinatarioId>";
            $destacadoHasta= "<introduzca destacadoHasta>";
            $asunto= "<introduzca asunto>";
            $contenido= "<introduzca contenido>";

            return [$nuevaEntrada, $fecha, $emisorId, $destinatarioId, $destacadoHasta, $asunto, $contenido];
	    } else {
            $rs= self::ejecutarConsulta(
                "SELECT * FROM Publicacion WHERE id=?",
                [$id]
            );
            return [$nuevaEntrada, $rs[0]["fecha"], $rs[0]["emisorId"], $rs[0]["destinatarioId"], $rs[0]["destacadaHasta"], $rs[0]["asunto"], $rs[0]["contenido"]];
        } 
    }

    //usuario
    private static function usuarioCrearDesdeRs(array $fila): Usuario
    {
        return new Usuario($fila["id"], $fila["identificador"], $fila["contrasenna"], $fila["codigoCookie"], $fila["caducidadCodigoCookie"], $fila["tipoUsuario"], $fila["nombre"], $fila["apellidos"]);
    }

    public static function obtenerUsuarioPorContrasenna(string $identificador, string $contrasenna): ?array
    {
        $conexion = obtenerPdoConexionBD();

        $sql = "SELECT * FROM Usuario WHERE identificador=? AND BINARY contrasenna=?";
        $select = $conexion->prepare($sql);
        $select->execute([$identificador, $contrasenna]);
        $rs = $select->fetchAll();

        return $select->rowCount()==1 ? $rs[0] : null;
    }

    public static function usuarioObtenerPorId(int $id): ?Usuario
    {
        $rs = self::ejecutarConsulta(
            "SELECT * FROM Usuario WHERE id=?",
            [$id]
        );
        if ($rs) return self::usuarioCrearDesdeRs($rs[0]);
        else return null;
    }

    public static function usuarioCrear(string $identificador, string $contrasenna, string $codigoCookie, string $caducidadCodigoCookie, int $tipoUsuario, string $nombre, string $apellidos): bool
    {
        return self::ejecutarActualizacion(
            "INSERT INTO Usuario (identificador, contrasenna, codigoCookie, caducidadCodigoCookie, tipoUsuario, nombre, apellidos) VALUES (?, ?, ?, ?, ?, ?, ?)",
            [$identificador, $contrasenna, $codigoCookie, $caducidadCodigoCookie, $tipoUsuario, $nombre, $apellidos]
        );
    }

    public static function usuarioObtenerTodas($posibleClausulaWhere): array
    {
        $datos = [];
        $rs = self::ejecutarConsulta(
            "SELECT * FROM Usuario $posibleClausulaWhere ORDER BY nombre",
            []
        );

        foreach ($rs as $fila) {
            $usuario = self::usuarioCrearDesdeRs($fila);
            array_push($datos, $usuario);
        }

        return $datos;
    }
	public static function eliminarUsuarioPorId(int $id): bool
    {
        $sql = "DELETE FROM Usuario WHERE id=?";
        return self::ejecutarActualizacion($sql, [$id]);
    }

    public static function usuarioGuardarPorId(int $id, string $identificador, string $contrasenna, string $codigoCookie, string $caducidadCodigoCookie, int $tipoUsuario, string $nombre, string $apellidos): bool
    {
        return self::ejecutarActualizacion(
            "UPDATE Usuario SET identificador=?, contrasenna=?, codigoCookie=?, caducidadCodigoCookie=?, tipoUsuario=?, nombre=?, apellidos=? WHERE id=?",
            [$identificador, $contrasenna, $codigoCookie, $caducidadCodigoCookie, $tipoUsuario, $nombre, $apellidos, $id]
        );
    }

    public static function usuarioFicha($id): array
    {
        $nuevaEntrada = ($id == -1);
	    if ($nuevaEntrada) {
            $usuarioIdentificador= "<introduzca identificador>";
            $usuarioContrasenna= "<introduzca contrasenna>";
            $usaurioNombre = "<introduzca nombre>";
            $usuarioApellidos= "<introduzca apellidos>";

            return [$nuevaEntrada, $usuarioIdentificador, $usuarioContrasenna, $usaurioNombre, $usuarioApellidos];
	    } else {
            $rs= self::ejecutarConsulta(
                "SELECT * FROM Usuario WHERE id=?",
                [$id]
            );
            return [$nuevaEntrada, $rs[0]["identificador"], $rs[0]["contrasenna"], $rs[0]["nombre"], $rs[0]["apellidos"]];
        }
        
        
    }

    public static function pintarInfoSesion() {
        if (haySesionRamIniciada() && $_SESSION["id"] != -1) {
            echo "<span>Sesión iniciada por <a href='UsuarioPerfilVer.php'>$_SESSION[identificador]</a> ($_SESSION[nombre] $_SESSION[apellidos]) <a href='SesionCerrar.php'>Cerrar sesión</a></span>";
        } else {
            echo "<a href='SesionInicioFormulario.php'>Iniciar sesión</a>";
        }
    }

    public static function redireccionar(string $url)
    {
        header("Location: $url");
        exit;
    }

    public static function destruirSesionRamYCookie()
    {
        session_destroy();
        actualizarCodigoCookieEnBD(Null);
        borrarCookies();
        unset($_SESSION); // Por si acaso
    }
    
}
