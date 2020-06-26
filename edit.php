<?php
    require_once('db.php');

    $id = '';
    $change_date = '';
    $floor = '';
    $position = '';
    $power = '';
    $brand = '';
    $error = false;

    if(isset($_GET['edit']) && ($_GET['id'])){
        $sql = 'SELECT id, change_date, floor, position, power, brand FROM lightbulb WHERE id=:id';
        $sth = $pdo->prepare($sql);
        $sth->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
        $sth->execute();
        $data = $sth->fetch(PDO::FETCH_ASSOC);
        if(gettype($data) === 'boolean'){
            header('Location : index.php');
            exit;
        }
        $change_date = $data['change_date'];
        $floor = $data['floor'];
        $position = $data['position'];
        $power = $data['power'];
        $brand = $data['brand'];
        $id = htmlentities($_GET['id']);
    }

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
        if(strlen(trim($_POST['power'])) !== 0){
            $power = trim($_POST['power']);
        }else{
            $error = true;
        }
        if(strlen(trim($_POST['brand'])) !== 0){
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
                $sql = 'UPDATE lightbulb SET change_date=:change_date, floor=:floor, position=:position, power=:power, brand=:brand WHERE id=:id';
            }else{
                $sql = 'INSERT INTO lightbulb(change_date, floor, position, power, brand) VALUES (:change_date, :floor, :position, :power, :brand)';
            }
            $sth = $pdo->prepare($sql);
            $sth->bindValue(':change_date', strftime("%Y-%m-%d", strtotime($change_date)), PDO::PARAM_STR);
            $sth->bindParam(':floor', $floor, PDO::PARAM_STR);
            $sth->bindParam(':position', $position, PDO::PARAM_STR);
            $sth->bindParam(':power', $power, PDO::PARAM_STR);
            $sth->bindParam(':brand', $brand, PDO::PARAM_STR);

            if(isset($_POST['edit']) && ($_POST['id'])){
                $sth->bindParam(':id', $id, PDO::PARAM_INT);
            }

            $sth->execute();

            header('Location: index.php');
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="medias/favicon.ico" type="image/x-icon">
    <title>Ajout/Modification</title>
</head>
<body>
    <?php
        if(isset($_GET['edit']) && ($_GET['id'])){
            $titleText = "Modifier la ligne";
        }else{
            $titleText = "Ajouter une ampoule";
        }
    ?>
    <h1><?=$titleText?></h1>

    <div>
        <form action="" method="post">
            <div>
                <label for="change_date">Date du changement de l'ampoule :</label>
                <input type="date" id="change_date" name="change_date" value="<?=$change_date?>">
            </div>
            <div>
                <label for="floor">Étage :</label>
                <select name="floor" id="floor" >
                    <?php 
                        if(isset($_GET['id']) && isset($_GET['edit'])){
                            $value = $floor;
                            $selectText = $floor;
                        }else{
                            $value = "";
                            $selectText = "Choisissez un étage";
                        }
                    ?>
                    <option value="<?=$value?>"><?=$selectText?></option>
                    <option value="Premier étage">Premier étage</option>
                    <option value="Deuxième étage">Deuxième étage</option>
                    <option value="Troisième étage">Troisième étage</option>
                    <option value="Quatrième étage">Quatrième étage</option>
                    <option value="Cinquième étage">Cinquième étage</option>
                    <option value="Sixième étage">Sixième étage</option>
                    <option value="Septième étage">Septième étage</option>
                    <option value="Huitième étage">Huitième étage</option>
                    <option value="Neuvième étage">Neuvième étage</option>
                    <option value="Dixième étage">Dixième étage</option>
                    <option value="Onzième étage">Onzième étage</option>
                </select>
 
            </div>
            <div>
                <label for="position">Coté du couloir :</label>
                <select name="position" id="position">
                <?php 
                        if(isset($_GET['id']) && isset($_GET['edit'])){
                            $value = $position;
                            $selectText = $position;
                        }else{
                            $value = "";
                            $selectText = "Choisissez un emplacement";
                        }
                    ?>
                    <option value="<?=$value?>"><?=$selectText?></option>
                    <option value="Côté droit">Côté droit</option>
                    <option value="Côté gauche">Côté gauche</option>
                    <option value="Fond">Fond</option>
                </select>
            
            </div>
            <div>
                <label for="power">Puissance et marque de l'ampoule :</label>
                <input type="text" id="power" name="power" placeholder ="Puissance en Watts" value="<?=$power?>">
                <input type="text" id="brand" name="brand" placeholder="Marque" value="<?=$brand?>">
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
