<?php
    require_once "_Varios.php";
    $identificador= $_REQUEST["identificador"];
    $contrasenna= $_SESSION["contrasenna"];
    $nombre= $_REQUEST["nombre"];
    $apellidos= $_REQUEST["apellidos"];
    if(isset($_REQUEST["foto"]))
        $foto= $_REQUEST["foto"];
?>
<html>
    <head>
        <title>Perfil</title>
    </head>
    <body>
        <form action="UsuarioPerfilGuardar.php" method="post">
            <label>Identificador:</label>
            <input type="text" name="identificador" value=<?=$identificador?>><br>
            <label>Contraseña:</label>
            <input type="text" name="contrasenna" value=<?=$contrasenna?>><br>
            <label>Nombre:</label>
            <input type="text" name="nombre" value=<?=$nombre?>><br>
            <label>Apellidos:</label>
            <input type="text" name="apellidos" value=<?=$apellidos?>><br>
            <input type="file" name="foto"><br>
            <input type="submit" value="Actualizar">
        </form>
    </body>
</html>