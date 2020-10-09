<html>
    <head>
        <title>Select</title>
    </head>
    <body>
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
    <select name="paises" id="paises">
        <?php
        echo '<option value="Francia">Francia</option>
        <option value="España">España</option>
        <option value="Alemania">Alemania</option>
        <option value="China">China</option>
        <option value="Italia">Italia</option>
        <option value="Rumania">Rumania</option>';
        ?>
    </select>

    </body>
</html>