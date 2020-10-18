<?php
/*if(isset($_REQUEST["numero"]))
    $numero= $_REQUEST["numero"];*/
?>
<html>
    <head>
        <title>Indica un Número</title>
    </head>
    <body>
        <p>Indica un numero</p>
        <form action="AdivinaNumero2.php" method="post">
            <input type="number" name="numero" value="0 /">
            <input type="submit" name="botton" value="Ocultar">
        </form>
    </body>
</html>
