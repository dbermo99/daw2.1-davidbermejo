<?php
/*session_start();
if($_SESSION["usuarioCreado"] == false)
    echo "<p>El usuario ya existe</p>";*/
?>
<html>
    <head>
        <title>Registro</title>
    </head>
    <body>

        <h1>Registrarse</h1>
        <form action="UsuarioNuevoCrear.php" method="post">
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
                    <td>Nombre</td>
                    <td><input type="text" name="nombre"></td>
                </tr>
                <tr>
                    <td>Apellidos</td>
                    <td><input type="text" name="apellidos"></td>
                </tr>
                <tr>
                    <td><input type="submit" name="botton" value="Registrarse"></td>
                </tr>
            </table>
        </form>
    </body>
</html>