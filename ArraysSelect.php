<?php
$paises= [
    5=> "Francia",
    8=> "España",
    15=> "Alemania",
    17=> "China",
    20=> "Italia",
    22=> "Rumania"
];
?>
<html>
    <head>
        <title>Select</title>
    </head>
    <body>

    <select name="paises" id="paises">
        <?php
        echo '<option value="Francia">Francia</option>
        <option value="1">España</option>
        <option value="2">Alemania</option>
        <option value="3">China</option>
        <option value="4">Italia</option>
        <option value="5">Rumania</option>';
        ?>
    </select>

    </body>
</html>