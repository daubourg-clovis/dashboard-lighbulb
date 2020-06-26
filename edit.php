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
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="medias/favicon.ico" type="image/x-icon">
    <link rel="icon" href="medias/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Ajout/Modification</title>
</head>
<body>
    <div class="box">

        <?php
            if(isset($_GET['edit']) && ($_GET['id'])){
                $titleText = "Modifier la ligne";
            }else{
                $titleText = "Ajouter une ampoule";
            }
        ?>
        <h1><?=$titleText?></h1>
        <button><a href="index.php">Annuler</a></button>
    
        <div>
            <form action="" method="post">
                <div class="form-group row">
                    <div class="col-lg-2">
                        <label for="change_date" class="col-form-label">Date du changement de l'ampoule :</label>
                    </div>
                    <div>
                        <input type="date" id="change_date" name="change_date" value="<?=$change_date?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-2">
                        <label for="floor" class="col-form-label">Étage :</label>
                    </div>
                    <select name="floor" id="floor" required>
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
                <div class="form-group row">
                    <div class="col-lg-2">
                        <label for="position" class="col-form-label">Coté du couloir :</label>
                    </div>
                    <select name="position" id="position" required>
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
                <div class="form-group row" >
                    <div class="col-lg-2">
                        <label for="power" class="col-form-label">Puissance et marque de l'ampoule :</label>
                    </div>
                    <div>
                        <input type="text" id="power" name="power" placeholder ="Puissance en Watts" value="<?=$power?>" required >
                        <input type="text" id="brand" name="brand" placeholder="Marque" value="<?=$brand?>" required>
                    </div>
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
    </div>
<script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

</body>
</html>
