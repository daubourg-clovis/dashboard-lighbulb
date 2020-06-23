<?php 
    require_once('db.php');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des ampoules</title>
</head>
<body>
    <h1>Ampoules</h1>
    <p><a href="edit.php">Entrer un changement d'ampoule</a></p>
    <table>
        <tr>
            <th>Date du Changement</th>
            <th>Étage</th>
            <th>Emplacement</th>
            <th>Puissance et marque de l'ampoule</th>
            <th>Modifier</th>
            <th>Supprimer</th>

        </tr>
        <?php 
            //Preparation Requete
            $sql = 'SELECT id, change_date, floor, position, power, brand FROM lightbulb';
            $sth = $pdo->prepare($sql);
            $sth->execute();
            $datas = $sth->fetchAll(PDO::FETCH_ASSOC);

            //Preparation formatage des dates 
            $intlDateFormatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::SHORT, IntlDateFormatter::NONE);
            
            //Affichage des éléments
            foreach($datas as $data){
                echo '<tr>';
                echo '<td>'.$intlDateFormatter->format(strtotime($data['change_date'])).'</td>';
                echo '<td>'.$data['floor'].'</td>';
                echo '<td>'.$data['position'].'</td>';
                echo '<td>'.$data['power'].' '.$data['brand'].'</td>';
                echo '<td><a href="edit.php?edit=1&id='.$data['id'].'"> Modifier</a></td>';
                echo '<td><a href="delete.php?id='.$data['id'].'">Supprimer</a></td>"';
                echo '</tr>';
            }
        ?>
    </table>
    
</body>
</html>