<?php

declare(strict_types=1);
session_start();
function obtenerPdoConexionBD(): PDO
{
    $servidor = "localhost";
    $bd = "MiniFb";
    $identificador = "root";
    $contrasenna = "";
    $opciones = [
        PDO::ATTR_EMULATE_PREPARES   => false, // turn off emulation mode for "real" prepared statements
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //make the default fetch be an associative array
    ];

    try {
        $conexion = new PDO("mysql:host=$servidor;dbname=$bd;charset=utf8", $identificador, $contrasenna, $opciones);
    } catch (Exception $e) {
        error_log("Error al conectar: " . $e->getMessage()); // El error se vuelca a php_error.log
        exit('Error al conectar'); //something a user can understand
    }

    return $conexion;
}

function obtenerUsuario($identificador, $contrasenna): ?array
{
    $pdo= obtenerPdoConexionBD();

    $sql= "SELECT * FROM Usuario WHERE identificador=? AND contrasenna=?";
    $sentencia = $pdo->prepare($sql);
    $sqlExito = $sentencia->execute([$identificador, $contrasenna]);

    $unaFilaAfectada= ($sentencia->rowCount() == 1);
    $ningunaFilaAfectada= ($sentencia->rowCount() == 0);
    $correcto= ($sqlExito && $unaFilaAfectada);
    $incorrecto= ($sqlExito && $ningunaFilaAfectada);

    $rs = $sentencia->fetchAll();

    if($correcto) {
        return ["id" => $rs[0]["id"], "identificador" => $rs[0]["identificador"], "contrasenna" => $rs[0]["contrasenna"], 
        "codigoCookie" => $rs[0]["codigoCookie"], "tipoUsuario" => $rs[0]["tipoUsuario"], "nombre" => $rs[0]["nombre"], 
        "apellidos" => $rs[0]["apellidos"], "foto" => $rs[0]["foto"]];
    }else
        return null;

    /*$pdo= obtenerPdoConexionBD();

    $sql= "SELECT * FROM Usuario WHERE identificador=? AND contrasenna=?";
    $sentencia = $pdo->prepare($sql);
    $sentencia->execute([$identificador, $contrasenna]);
    $rs = $sentencia->fetchAll();

   return $sentencia->rowCount()==1 ? rs[0] : null;*/

}

function marcarSesionComoIniciada($arrayUsuario)
{
    // TODO Anotar en el post-it todos estos datos:
    $_SESSION["id"] = $arrayUsuario["id"];
    $_SESSION["identificador"] = $arrayUsuario["identificador"];
    $_SESSION["tipoUsuario"] = $arrayUsuario["tipoUsuario"];
    $_SESSION["nombre"] = $arrayUsuario["nombre"];
    $_SESSION["apellidos"] = $arrayUsuario["apellidos"];
    $_SESSION["foto"] = $arrayUsuario["foto"];
}

function haySesionIniciada(): ?bool //se llama bool No boolean
{
    // TODO Pendiente hacer la comprobación.

    // Está iniciada si isset($_SESSION["id"])
    if(isset($_SESSION["id"])) {
        $conectado = true;
    } else {
        $conectado = false;
    }
    return $conectado;

}

function cerrarSesion()
{
    // TODO session_destroy() y unset de $_SESSION (por si acaso).
    session_destroy();
    unset($_SESSION["id"]);
    unset($_SESSION["identificador"]);
    unset($_SESSION["contrasenna"]);
    unset($_SESSION["codigoCookie"]);
    unset($_SESSION["tipoUsuario"]);
    unset($_SESSION["nombre"]);
    unset($_SESSION["apellido"]);
    unset($_SESSION["foto"]);
}

function crearUsuario($identificador, $contrasenna, $nombre, $apellidos, $foto)
{
    $pdo= obtenerPdoConexionBD();
    $usuarioExistente= obtenerUsuario($identificador, $contrasenna);
    if(!$usuarioExistente) {
        $sql= "INSERT INTO usuario(identificador, contrasenna, nombre, apellidos, foto) VALUES(?, ?, ?, ?, ?)";
        $sentencia = $pdo->prepare($sql);
        $sqlExito = $sentencia->execute([$identificador, $contrasenna, $nombre, $apellidos, $foto]);
    }else {
        redireccionar("UsuarioNuevoFormulario.php?error");
    }

}

function actualizarUsuarioEnBD($identificador, $contrasenna, $nombre, $apellidos, $foto)
{
    $pdo= obtenerPdoConexionBD();
    $sql= "UPDATE usuario SET identificador = '$identificador', contrasenna = '$contrasenna',
        nombre = '$nombre', apellidos = '$apellidos', foto = '$foto' WHERE id=$_SESSION[id]";
    $select = $pdo->prepare($sql);
    $select->execute([]);
    $_SESSION["identificador"] = $identificador;
    $_SESSION["contrasenna"] = $contrasenna;
    $_SESSION["nombre"] = $nombre;
    $_SESSION["apellidos"] = $apellidos;
    $_SESSION["foto"] = $foto;
}

// (Esta función no se utiliza en este proyecto pero se deja por si se optimizase el flujo de navegación.)
// Esta función redirige a otra página y deja de ejecutar el PHP que la llamó:
function redireccionar(string $url)
{
    header("Location: $url");
    exit;
}

function syso(string $contenido)
{
    file_put_contents('php://stderr', $contenido . "\n");
}