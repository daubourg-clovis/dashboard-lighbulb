<?php
    require_once('db.php');

    $id = '';
    $change_date = '';
    $floor = '';
    $position = '';
    $power = '';
    $brand = '';
    $error = false;

    if(count($_POST) > 0){
        // On vérifie que les champs ne soient pas vides, sinon on n'execute pas la requête
        if(strlen(trim($_POST['change_date']) !== 0)){
            $change_date = trim($_POST['change_date']);
        }else{
            $error = true;
        }
        if(strlen($_POST['floor']) !== 0){
            $floor = $_POST['floor'];
        }else{
            $error = true;
        }
        if(strlen($_POST['position']) !== 0){
            $position = $_POST['position'];
        }else{
            $error = true;
        }
        if(strlen(trim($_POST['power']) !== 0)){
            $power = trim($_POST['power']);
        }else{
            $error = true;
        }
        if(strlen(trim($_POST['brand']) !== 0)){
            $brand = trim($_POST['brand']);
        }else{
            $error = true;
        }

        //On transforme note id en entité html pour se protéger
        if(isset($_POST['edit']) && ($_POST['id'])){
            $id = htmlentities($_POST['id']);
        }

        // Si pas d'erreur, (aucun champ vide) on insère dans la bd
        if($error === false){
            if(isset($_POST['edit']) && ($_POST['id'])){
                $sql = 'UPDATE lightbulb SET change_date=:change_date, floor=:floor, position=:position, power=:power, brand=:brand';
            }else{
                $sql = 'INSERT INTO lightbulb(change_date, floor, position, power, brand) VALUES (:change_date, :floor, :position, :power, :brand';
            }
        }
    }
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
                <label for="power">Puissance et marque de l'ampoule :</label>
                <input type="text" id="power" name="power" placeholder ="Puissance en Watts">
                <input type="text" id="brand" name="brand" placeholder="Marque" >
            </div>
            <div>
                <?php
                    if(isset($_GET['id']) && isset($_GET['edit'])){
                        $validateText = 'Modifier';
                    }else{
                        $validateText = 'Ajouter';
                    }
                ?>
                <button type="submit"><?=$validateText?></button>
                <?php
                    if(isset($_GET['id']) && isset($_GET['edit'])){
                ?>
                <input type="hidden" name="edit" value="1">
                <input type="hidden" name="id" value="<?=$id?>">
                <?php 
                    }
                ?>
            </div>
        </form>
    </div>
    
</body>
</html>
