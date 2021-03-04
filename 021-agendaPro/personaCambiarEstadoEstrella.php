<?php
    require_once "_varios.php";
    $pdo = obtenerPdoConexionBD();
    $id = (int)$_REQUEST["id"];
    $ficha = $_REQUEST["ficha"];
    $sql= "UPDATE persona SET estrella = (NOT (SELECT estrella FROM persona WHERE id=?)) WHERE id=?";
    $select = $pdo->prepare($sql);
    $select->execute([$id, $id]);
    redireccionar($ficha);
?>
