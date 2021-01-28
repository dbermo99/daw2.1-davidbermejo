<?php

    require_once "_com/_Varios.php";
    require_once "_com/dao.php";

    // Comprobamos si hay sesión-usuario iniciada.
    //   - Si la hay, no intervenimos. Dejamos que la pág se cargue.
    //     (Mostrar info del usuario logueado y tal...)
    //   - Si NO la hay, redirigimos a SesionInicioFormulario.php

    if (!haySesionRamIniciada() && !intentarCanjearSesionCookie()) {
        redireccionar("SesionInicioFormulario.php");
    }

    $posibleClausulaWhere= "WHERE emisorId LIKE $_SESSION[id]";
    $publicaciones= dao::publicacionObtenerTodas($posibleClausulaWhere);

?>



<html>

<head>
    <meta charset='UTF-8'>
</head>



<body>

<?php dao::pintarInfoSesion(); ?>

<h1>Muro de <?php echo $_SESSION["identificador"]; ?></h1>

<p>/Aquí mostraremos los mensajes que hayan sido publicados para el usuario indicado como parámetro. Si no indican nada, veo los mensajes dirigidos a mí. Si indican otra cosa, veo los mensajes dirigidos a ese usuario.</p>

<table border='1'>

    <tr>
        <th>Id</th>
        <th>Fecha</th>
        <th>EmisorId</th>
        <th>DestinatarioId</th>
        <th>DestacadoHasta</th>
        <th>Asunto</th>
        <th>Contenido</th>
    </tr>

    <?php
    foreach ($publicaciones as $publicacion) { ?>
        <tr>

            <td><?= $publicacion->getId() ?></td>
            <td><?= $publicacion->getFecha() ?></td>
            <td><?= $publicacion->getEmisorId() ?></td>
            <td><?= $publicacion->getDestinatarioId() ?></td>
            <td><?= $publicacion->getDestacadoHasta() ?></td>
            <td><?= $publicacion->getAsunto() ?></td>
            <td><?= $publicacion->getContenido() ?></td>
        </tr>
    <?php } ?>

</table>

<a href='Index.php'>Ir al Contenido Público 1</a>

<a href='MuroVerGlobal.php'>Ir al Contenido Privado 1</a>

</body>

</html>