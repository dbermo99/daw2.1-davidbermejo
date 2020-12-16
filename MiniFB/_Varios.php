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

}

function marcarSesionComoIniciada($arrayUsuario)
{
    $_SESSION["id"] = $arrayUsuario["id"];
    $_SESSION["identificador"] = $arrayUsuario["identificador"];
    $_SESSION["contrasenna"] = $arrayUsuario["contrasenna"];
    $_SESSION["codigoCookie"] = $arrayUsuario["codigoCookie"];
    $_SESSION["tipoUsuario"] = $arrayUsuario["tipoUsuario"];
    $_SESSION["nombre"] = $arrayUsuario["nombre"];
    $_SESSION["apellidos"] = $arrayUsuario["apellidos"];
    $_SESSION["foto"] = $arrayUsuario["foto"];
}

function haySesionIniciada(): ?bool
{
    if(isset($_SESSION["id"])) {
        $conectado = true;
    } else {
        $conectado = false;
    }
    return $conectado;
}

function cerrarSesion()
{
    session_destroy();
    borrarCookieRecordar();
    unset($_SESSION);
}

function crearUsuario($identificador, $contrasenna, $nombre, $apellidos, $foto)
{
    $pdo= obtenerPdoConexionBD();

    $sql= "SELECT * FROM Usuario WHERE identificador=?";
    $sentencia = $pdo->prepare($sql);
    $sqlExito = $sentencia->execute([$identificador]);
    $rs = $sentencia->fetchAll();

    if(!rs[0]) {
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
    $sql= "UPDATE usuario SET identificador = ?, contrasenna = ?, nombre = ?, apellidos = ?, foto = ? WHERE id=?";
    $select = $pdo->prepare($sql);
    $select->execute([$identificador, $contrasenna, $nombre, $apellidos, $foto, $_SESSION[id]]);
    $_SESSION["identificador"] = $identificador;
    $_SESSION["contrasenna"] = $contrasenna;
    $_SESSION["nombre"] = $nombre;
    $_SESSION["apellidos"] = $apellidos;
    $_SESSION["foto"] = $foto;
}

function intentarCanjearSesionCookie(): bool
{
    // TODO Comprobar si hay una "sesión-cookie" válida:
    //   - Ver que vengan DOS cookies "identificador" y "codigoCookie".
    //   - BD: SELECT ... WHERE identificador=? AND BINARY codigoCookie=?
    //   - ¿Ha venido un registro? (Igual que el inicio de sesión)
    //     · Entonces, se la canjeamos por una SESIÓN RAM INICIADA: marcarSesionComoIniciada($arrayUsuario)
    //     · Además, RENOVAMOS (re-creamos) la cookie.
    //   - IMPORTANTE: si las cookies NO eran válidas, tenemos que borrárselas.
    //   - En cualquier caso, devolver true/false.
    $hayCookie= false;
    if(isset($_COOKIE["identificador"]) && isset($_COOKIE["codigoCookie"])) {
        $hayCookie= true;
        $pdo= obtenerPdoConexionBD();
        $sql= "SELECT * FROM Usuario WHERE identificador=? && BINARY codigoCookie=?";
        $sentencia = $pdo->prepare($sql);
        $sqlExito = $sentencia->execute([$_COOKIE["identificador"], $_COOKIE["codigoCookie"]]);
        $rs = $sentencia->fetchAll();
        $arrayUsuario= obtenerUsuario($rs[0]["identificador"], $rs[0]["contrasenna"]);
        marcarSesionComoIniciada($arrayUsuario);
        generarCookieRecordar($arrayUsuario);
    } else {
        borrarCookieRecordar();
    }
    return $hayCookie;
}

function pintarInfoSesion() {
    if (haySesionIniciada()) {
        echo "<span>Sesión iniciada por <a href='UsuarioPerfilVer.php>'$_SESSION[identificador]'</a> ($_SESSION[nombre] $_SESSION[apellidos]) <a href='SesionCerrar.php'>Cerrar sesión</a></span>";
    } else {
        echo "<a href='SesionInicioFormulario.php'>Iniciar sesión</a>";
    }
}

function generarCookieRecordar(array $arrayUsuario)
{
    // Creamos un código cookie muy complejo (no necesariamente único).
    $codigoCookie = generarCadenaAleatoria(32); // Random...
    $_SESSION["codigoCookie"] = $codigoCookie;

    // TODO guardar código en BD
    // TODO Para una seguridad óptima convendría anotar en la BD la fecha de caducidad de la cookie y no aceptar ninguna cookie pasada dicha fecha.
    $caducidad= time() + 60;
    $pdo= obtenerPdoConexionBD();
    $sql= "UPDATE usuario SET codigoCookie = ?, caducidadCodigoCookie = ? WHERE id=?";
    $select = $pdo->prepare($sql);
    $select->execute([$codigoCookie, $caducidad, $arrayUsuario["id"]]);

    // TODO Enviamos al cliente, en forma de cookies, el identificador y el codigoCookie: setcookie(...) ...
    setcookie("identificador", $arrayUsuario["identificador"], $caducidad);
    setcookie("codigoCookie", $codigoCookie, $caducidad);
}

function borrarCookieRecordar()
{
    // TODO Eliminar el código cookie de nuestra BD.
    $pdo= obtenerPdoConexionBD();
    $sql= "UPDATE usuario SET codigoCookie = null, caducidadCodigoCookie = null WHERE id=?";
    $select = $pdo->prepare($sql);
    $select->execute([$_SESSION["id"]]);

    // TODO Pedir borrar cookie (setcookie con tiempo time() - negativo...)
    $tiempo= time() - 60;
    setcookie("identificador", "", $tiempo);
    setcookie("codigoCookie", "", $tiempo);
}

function generarCadenaAleatoria(int $longitud): string
{
    for ($s = '', $i = 0, $z = strlen($a = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789')-1; $i != $longitud; $x = rand(0,$z), $s .= $a[$x], $i++);
    return $s;
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