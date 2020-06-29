<?php 
    require_once('db.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="medias/favicon.ico" type="image/x-icon">
    <link rel="icon" href="medias/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Gestion des ampoules</title>
</head>
<body>
    <header id="header-index">
        <h1 id="h1-index">Gérer les ampoules de l'immeuble</h1>
    </header>

    <div class="container">

        <div class="vert-align">
            <div id="btn-margin">
            <a href="edit.php" class="btn btn-primary btn-lg">Entrer un changement d'ampoule</a>
            </div>

                <table class="table table-bordered">
                    <tr>
                        <th>Date du Changement</th>
                        <th>Étage</th>
                        <th>Emplacement</th>
                        <th>Puissance</th>
                        <th>Marque</th>
                        <th>Modifier</th>
                        <th>Supprimer</th>
            
                    </tr>
                    <?php 
                        //Preparation Requete
                        $sql = 'SELECT id, change_date, floor, position, power, brand FROM lightbulb ORDER BY change_date DESC';
                        $sth = $pdo->prepare($sql);
                        $sth->execute();
                        $datas = $sth->fetchAll(PDO::FETCH_ASSOC);
            
                        //Preparation formatage des dates 
                        $intlDateFormatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::SHORT, IntlDateFormatter::NONE);
                        
                        //Affichage des éléments
                        foreach($datas as $data){
                            echo '<tr id="tr-hover">';
                            echo '<td>'.$intlDateFormatter->format(strtotime($data['change_date'])).'</td>';
                            echo '<td>'.$data['floor'].'</td>';
                            echo '<td>'.$data['position'].'</td>';
                            echo '<td id="pw-content">'.$data['power'].'</td>';
                            echo '<td>'.$data['brand'].'</td>';
                            echo '<td class="svg-center"><a href="edit.php?edit=1&id='.$data['id'].'"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="edit"><path d="M14.078 4.232l-12.64 12.639-1.438 7.129 7.127-1.438 12.641-12.64-5.69-5.69zm-10.369 14.893l-.85-.85 11.141-11.125.849.849-11.14 11.126zm2.008 2.008l-.85-.85 11.141-11.125.85.85-11.141 11.125zm18.283-15.444l-2.816 2.818-5.691-5.691 2.816-2.816 5.691 5.689z"/></svg></a></td>';
                            echo '<td class="svg-center"><a href="delete.php?id='.$data['id'].'" onclick="return delFunction()"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="delete"><path d="M23.954 21.03l-9.184-9.095 9.092-9.174-2.832-2.807-9.09 9.179-9.176-9.088-2.81 2.81 9.186 9.105-9.095 9.184 2.81 2.81 9.112-9.192 9.18 9.1z"/></svg></a></td>';
                            echo '<script> function delFunction(){ let del = confirm("Êtes vous sur de vouloir supprimer ?"); if (del == false){return false;}}</script>';
                            echo '</tr>';
                        }
                    ?>
                </table>
                <div id="btn-end">
                <a href="edit.php" class="btn btn-primary btn-sm">Entrer un changement d'ampoule</a>
                </div>
            </div>
    </div>
<script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

</body>
</html>