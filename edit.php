<?php
    require_once('db.php');

    $id = '';
    $change_date = '';
    $floor = '';
    $position = '';
    $power = '';
    $brand = '';
    $error = false;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajout/Modification</title>
</head>
<body>
    <h1>Ajouter/Modifier une ligne</h1>

    <div>
        <form action="" method="post">
            <div>
                <label for="change_date">Date du changement de l'ampoule :</label>
                <input type="date" id="change_date" name="change_date" >
            </div>
            <div>
                <label for="floor">Étage :</label>
                <select name="floor" id="floor">
                    <option value="">Choisissez un étage</option>
                    <option value="floor1">Premier étage</option>
                    <option value="floor2">Deuxième étage</option>
                    <option value="floor3">Troisième étage</option>
                    <option value="floor4">Quatrième étage</option>
                    <option value="floor5">Cinquième étage</option>
                    <option value="floor6">Sixième étage</option>
                    <option value="floor7">Septième étage</option>
                    <option value="floor8">Huitième étage</option>
                    <option value="floor9">Neuvième étage</option>
                    <option value="floor10">Dixième étage</option>
                    <option value="floor11">Onzième étage</option>
                </select>
 
            </div>
            <div>
                <label for="position">Coté du couloir :</label>
                <select name="position" id="position">
                    <option value="">Choisissez un emplacement</option>
                    <option value="right">Côté droit</option>
                    <option value="left">Côté gauche</option>
                    <option value="end">Fond</option>
                </select>
            
            </div>
            <div>
                <label for="power brand">Puissance et marque de l'ampoule :</label>
                <input type="text" id="power" name="power" placeholder ="Puissance en Watts">
                <input type="text" id="brand" name="brand" placeholder="Marque" >
            </div>
        </form>
    </div>
    
</body>
</html>
