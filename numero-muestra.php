<?php
    $numero= $_REQUEST["numero"];
    if(is_numeric($numero))
        $incremento= $numero+1;
?>

<html>
    <head>
        <title>Incremento</title>
    </head>
    <body>

        <p>Indica un número</p>
        <form action="numero-muestra.php" method="get">
            <?php
                if(is_numeric($numero))
                    echo "<input type='number' name='numero' value='$incremento'>";
                else
                    echo "<input type='text' name='numero' value='Indica un numero'>";
            ?>
            <input type="submit" name="botton" value="Enviar">
        </form>

    </body>
</html>
