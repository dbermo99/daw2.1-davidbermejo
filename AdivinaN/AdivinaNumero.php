<?php
/*if(isset($_REQUEST["numero"]))
    $numero= $_REQUEST["numero"];*/
?>
<html>
    <head>
        <title>Indica un Número</title>
    </head>
    <body>

        <form action="AdivinaNumero2.php" method="post">
            <p>Indica un numero</p>
            <input type="number" name="oculto" value="0 /">
            <input type="submit"  value="Ocultar">
        </form>
    </body>
</html>
