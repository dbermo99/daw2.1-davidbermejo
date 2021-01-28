<?php

    require_once "_com/_Varios.php";
    require_once "_com/dao.php";

    // Comprobamos si hay sesión-usuario iniciada.
    //   - Si la hay, no intervenimos. Dejamos que la pág se cargue.
    //     (Mostrar info del usuario logueado y tal...)
    //   - Si NO la hay, redirigimos a SesionInicioFormulario.php

    if (!haySesionRamIniciada() && !intentarCanjearSesionCookie()) {
        dao::redireccionar("SesionInicioFormulario.php");
    }

    $posibleClausulaWhere= "";
    $publicaciones= dao::publicacionObtenerTodas($posibleClausulaWhere);

?>



<html>

<head>
    <meta charset='UTF-8'>
</head>



<body>

<?php dao::pintarInfoSesion(); ?>

<h1>Muro global</h1>

<p>Aquí mostraremos todos los mensajes de todos a todos.</p>

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

<a href='MuroVerDe.php'>Ir a mi muro.</a>

</body>

</html>