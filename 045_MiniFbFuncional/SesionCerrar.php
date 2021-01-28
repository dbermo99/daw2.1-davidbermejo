<?php

    require_once "_com/_Varios.php";
    require_once "_com/dao.php";

    dao::destruirSesionRamYCookie();

    dao::redireccionar("Index.php");

?>
