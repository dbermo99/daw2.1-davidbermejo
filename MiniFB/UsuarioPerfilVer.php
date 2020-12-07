<?php
    require_once "_Varios.php";
    $identificador= $_REQUEST["identificador"];
    $contrasenna= $_SESSION["contrasenna"];
    $nombre= $_REQUEST["nombre"];
    $apellidos= $_REQUEST["apellidos"];

    $pdo= obtenerPdoConexionBD();
    $sql= "SELECT foto FROM usuario WHERE id=$_SESSION[id]";
    $sentencia = $pdo->prepare($sql);
    $sentencia->execute([]);
    $rs = $sentencia->fetchAll();
    if($rs[0]["foto"] != null) {
        echo "<img src='fotos/".$rs[0]["foto"]."' width='100' heigth='100'>";
    } else {
        echo "<img src='fotos/fotoPerfil.jpg' width='100' heigth='100'>";
    }

?>
<html>
    <head>
        <title>Perfil</title>
    </head>
    <body>
        <form action="UsuarioPerfilGuardar.php" method="post" enctype="multipart/form-data">
            <label>Identificador:</label>
            <input type="text" name="identificador" value=<?=$identificador?>><br>
            <label>Contraseña:</label>
            <input type="text" name="contrasenna" value=<?=$contrasenna?>><br>
            <label>Nombre:</label>
            <input type="text" name="nombre" value=<?=$nombre?>><br>
            <label>Apellidos:</label>
            <input type="text" name="apellidos" value=<?=$apellidos?>><br>
            <label>Foto Perfil:</label>
            <input type="file" name="foto" id="foto"><br>
            <input type="submit" value="Actualizar">
        </form>
    </body>
</html>