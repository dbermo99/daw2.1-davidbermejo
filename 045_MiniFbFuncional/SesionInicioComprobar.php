<?php

require_once "_com/_Varios.php";
require_once "_com/dao.php";

$arrayUsuario = dao::obtenerUsuarioPorContrasenna($_REQUEST["identificador"], $_REQUEST["contrasenna"]);

if ($arrayUsuario) { // Identificador existía y contraseña era correcta.
    establecerSesionRam($arrayUsuario);

    if (isset($_REQUEST["recordar"])) {
        establecerSesionCookie($arrayUsuario);
    }
    $_SESSION["identificador"]= $_REQUEST["identificador"];
    dao::redireccionar("MuroVerGlobal.php");
} else {
    dao::redireccionar("SesionInicioFormulario.php?datosErroneos");
}