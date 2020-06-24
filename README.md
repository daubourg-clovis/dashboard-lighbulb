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


## Supression d'une ligne 

Dans un fichier séparé delete.php qu'on a lié à notre à notre page dans notre tableau on fait le code php suivant pour pouvoir supprimer une ligne
Dans un premier temps on la lie aussi a notre page de connection à le base de données pour que l'action de la requete SQL de supression puisse se faire.
On précise dans un premier temps qu'on veut supprimer seulement sur lequel on a cliqué pour se faire avant de faire notre reqête on l'inclut dans un ```if(isset($_GET['id']))``` puis ont fait notre reqête sans oublier de la préparer avec l'aide d'un marqueur ```:id``` auquel on attribue la valeur ```$_GET['id']```. IN lui lie aussi le statement ```PDO::PARAM_INT``` pour préciser que l'id est un chiffre entier, ce qui nous sert de protection.
```
    $sql = 'DELETE FROM lightbulb WHERE id=:id';
    $sth = $pdo->prepare($sql);
    $sth->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $sth->execute();

```

On ajoute après notre condition if la ligne ```header('Location: index.php');``` pour lui dire de nous rediriger directement sur la page index.php ce qui aura pour effet de ne pas nous faire changer de page si la requête de supression s'execute bien.