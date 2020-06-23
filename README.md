# Création d'un dashboard pour un gardien d'immeuble devant gérer le changement des ampoules du bâtiment

On configure d'abord la connection à la base de donnée

## Affichage des données :

On créer une page index.php et on y inclut notre connection à la base de donnée.

On met en place un tableau avec l'entête des colonnes en html et le corps de ces colonnes en php, qui seront crées et remplies par les informations de notre base de donnée.

Pour cela on fait d'abord une requete SQL ``` $sql = 'SELECT id, change_date, floor, position, power, brand FROM lightbulb';``` qu'on prépare afin de se protéger des injections SQL.
On va ensuite mettres les données dans un tableau php ```$datas = $sth->fetchAll(PDO::FETCH_ASSOC);``` afin de pouvoir les insérer dans notre tableau.
On affiche les données qui nous intéressent en passant par un ```foreach($datas as $data)``` puis en faisant un ```echo``` pour chaque ligne du tableau :
```
    echo '<tr>';
    echo '<td>'.$intlDateFormatter->format(strtotime($data['change_date'])).'</td>';
    echo '<td>'.$data['floor'].'</td>';
    echo '<td>'.$data['position'].'</td>';
    echo '<td>'.$data['power'].' '.$data['brand'].'</td>';
    echo '<td><a href="edit.php?edit=1&id='.$data['id'].'"> Modifier</a></td>';
    echo '<td><a href="delete.php?id='.$data['id'].'">Supprimer</a></td>"';
    echo '</tr>';
```
On vérifie qu'on a bien indiqué le format d'affichage de notre date au préalable afin d'avoir un affichage en français de celle-ci : 
```
    $intlDateFormatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::SHORT, IntlDateFormatter::NONE);
```
On inclut également les lignes du modification et de supression redirigeant vers les pages php edit.php et delete.php que l'on va gérer plus tard.

On commit et on push sur github avant de passer à la suite !