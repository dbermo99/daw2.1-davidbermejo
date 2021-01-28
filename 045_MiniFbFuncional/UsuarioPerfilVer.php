<?php

    require_once "_com/_Varios.php";
    require_once "_com/dao.php";

    if(isset($_SESSION["id"])) {
        $id = (int)$_SESSION["id"];
	    $datos= DAO::usuarioFicha($id);
    }else {
        $datos= [true];
    }
    

?>
<html>
<head>
    <meta charset='UTF-8'>
</head>
<body>

    <?php dao::pintarInfoSesion(); ?>

    <?php if ($datos[0] == true) { ?>
	    <h1>Nueva ficha de usuario</h1>
    <?php } else { ?>
	    <h1>Ficha de usuario</h1>
    <?php } ?>

    <form method='post' action='UsuarioPerfilGuardar.php'>

        <input type='hidden' name='id' value='<?= $id ?>' />

        <label for='nombre'>Identificador</label>
        <?php if(!haySesionRamIniciada() || $_SESSION["id"] == -1) { ?>
            <input type='text' name='identificador' placeholder="Identificador" />
        <?php } else { ?>
            <input type='text' name='identificador' value='<?=$datos[1]?>' />
        <?php } ?>
        <br/>

        <label for='apellidos'> Contraseña</label>
        <?php if(!haySesionRamIniciada() || $_SESSION["id"] == -1) { ?>
            <input type='text' name='contrasenna' placeholder="Contraseña" />
        <?php } else { ?>
            <input type='text' name='contrasenna' value='<?=$datos[2]?>' />
        <?php } ?>
        <br/>

        <label for='nombre'>Nombre</label>
        <?php if(!haySesionRamIniciada() || $_SESSION["id"] == -1) { ?>
            <input type='text' name='nombre' placeholder="Nombre" />
        <?php } else { ?>
            <input type='text' name='nombre' value='<?=$datos[3]?>' />
        <?php } ?>
        <br/>

        <label for='apellidos'> Apellidos</label>
        <?php if(!haySesionRamIniciada() || $_SESSION["id"] == -1) { ?>
            <input type='text' name='apellidos' placeholder="Apellidos" />
        <?php } else { ?>
            <input type='text' name='apellidos' value='<?=$datos[4]?>' />
        <?php } ?>
        <br/>

        <?php if ($datos[0]) { ?>
	        <input type='submit' name='crear' value='Crear usuario' />
        <?php } else { ?>
	        <input type='submit' name='guardar' value='Guardar cambios' />
        <?php } ?>

    </form>

    <a href="MuroVerGlobal.php">Volver al muro global</a>
    <a href="MuroVerDe.php">Volver al muro personal</a>

</body>

</html>