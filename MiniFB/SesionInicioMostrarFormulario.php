<?php

?>

<html>

<head>
    <meta charset='UTF-8'>
</head>



<body>

<h1>Iniciar Sesión</h1>

<form action="SesionInicioComprobar.php" method="post">
    <label>Usuario</label>
    <input type="text" name="identificador"><br>
    <label>Contraseña</label>
    <input type="password" name="contrasenna"><br>
    <input type="submit" name="botton" value="IniciarSesion">
</form>
<form action="UsuarioNuevoFormulario.php" method="post">
    <input type="submit" name="botton" value="Registrarse">
</form>

</body>

</html>