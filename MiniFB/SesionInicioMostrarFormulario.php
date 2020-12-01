<?php

?>

<html>

<head>
    <meta charset='UTF-8'>
</head>



<body>

<h1>Iniciar Sesión</h1>

<form action="SesionInicioComprobar.php" method="post">
    <table>
        <tr>
            <td>Usuario</td>
            <td><input type="text" name="identificador"></td>
        </tr>
        <tr>
            <td>Contrasenna</td>
            <td><input type="password" name="contrasenna"></td>
        </tr>
        <tr>
            <td><input type="submit" name="botton" value="IniciarSesion"></td>
        </tr>
    </table>
</form>

</body>

</html>