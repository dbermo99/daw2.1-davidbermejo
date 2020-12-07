<?php
   if(isset($_REQUEST["error"])) {
       echo "<p>El usuario ya existe</p>";
   }
?>
<html>
    <head>
        <title>Registro</title>
    </head>
    <body>

        <h1>Registrarse</h1>
        
        <form action="UsuarioNuevoCrear.php" method="post" enctype="multipart/form-data">
            <label>Usuario</label>
            <input type="text" name="identificador"><br>
            <label>Contraseña</label>
            <input type="password" name="contrasenna"><br>
            <label>Nombre</label>
            <input type="text" name="nombre"><br>
            <label>Apellidos</label>
            <input type="text" name="apellidos"><br>
            <label>Foto Perfil:</label>
            <input type="file" name="foto" id="foto"><br>
            <input type="submit" name="botton" value="Registrarse">
        </form>
    </body>
</html>