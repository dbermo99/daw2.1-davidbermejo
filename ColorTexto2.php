<?php
    if(isset($_REQUEST["color"]))
        $color= $_REQUEST["color"];
?>
<html>
    <head>
        <title>Texto</title>
        <style>
            #texto{
                color: <?= $color ?>;
            }
        </style>
    </head>

    <body>
        <p id="texto">Estudiando JS</p>
    </body>
</html>
