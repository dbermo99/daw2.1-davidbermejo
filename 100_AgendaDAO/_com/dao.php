<?php

require_once "Clases.php";
require_once "Varios.php";

class DAO
{
    private static $pdo = null;

    private static function obtenerPdoConexionBD()
    {
        $servidor = "localhost";
        $identificador = "root";
        $contrasenna = "";
        $bd = "agenda"; // Schema
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



    /* CATEGORÍA */

    private static function categoriaCrearDesdeRs(array $fila): Categoria
    {
        return new Categoria($fila["id"], $fila["nombre"]);
    }

    public static function categoriaObtenerPorId(int $id): ?Categoria
    {
        $rs = self::ejecutarConsulta(
            "SELECT * FROM categoria WHERE id=?",
            [$id]
        );
        if ($rs) return self::crearCategoriaDesdeRs($rs[0]);
        else return null;
    }

    public static function categoriaActualizar($id, $nombre)
    {
        self::ejecutarActualizacion(
            "UPDATE categoria SET nombre=? WHERE id=?",
            [$nombre, $id]
        );
    }

    public static function categoriaCrear(string $nombre): bool
    {
        return self::ejecutarActualizacion(
            "INSERT INTO categoria (nombre) VALUES (?)",
            [$nombre]
        );
    }

    public static function categoriaObtenerTodas(): array
    {
        $datos = [];
        $rs = self::ejecutarConsulta(
            "SELECT * FROM categoria ORDER BY nombre",
            []
        );

        foreach ($rs as $fila) {
            $categoria = self::categoriaCrearDesdeRs($fila);
            array_push($datos, $categoria);
        }

        return $datos;
    }
	public static function eliminarCategoriaPorId(int $id): bool
    {
        
        $sql = "DELETE FROM categoria WHERE id=?";

        return self::ejecutarActualizacion($sql, [$id]);
    }

    public static function categoriaGuardarPorId(int $id, string $nombre): bool
    {
        return self::ejecutarActualizacion(
            "UPDATE categoria SET nombre=? WHERE id=?",
            [$nombre, $id]
        );
    }

    public static function categoriaFicha($id): array
    {
        $nuevaEntrada = ($id == -1);
	    if ($nuevaEntrada) {
		    $categoriaNombre = "<introduzca nombre>";
	    } else {
            $rs= self::ejecutarConsulta(
                "SELECT nombre FROM categoria WHERE id=?",
                [$id]
            );
		    $categoriaNombre = $rs[0]["nombre"];
	    }
        $personas= self::ejecutarConsulta(
            "SELECT * FROM persona WHERE categoriaId=? ORDER BY nombre",
            [$id]
        );
        return [$nuevaEntrada, $categoriaNombre, $personas];
    }

}