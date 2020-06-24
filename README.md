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

## Ajout/Modification d'un ligne 

On crée une page edit.php qu'on a lié à nos href sur notre page index.php, de manière normale pour le simple ajout de ligne: ```<a href="edit.php">``` mais avec une condition pour la modification ```<a href="edit.php?edit=1&id='.$data['id'].'">```.

On commence encore une fois par la lié à notre page de connection à la base de donnée.

On crée ensuite les variables qui nous seront utiles pour l'ajout comme pour la modification : 
```
    $id = '',
    $change_date = '';
    $floor = '';
    $position = '';
    $power = '';
    $brand = '';
    $error = false;
```

Elle sont vide pour le moment afin de pouvoir les remplir automatiquement avec notre formulaire. On crée également la variable booléenne ```$error = false;``` pour vérifier plus tard si il y a une erreur ou pas, et s'il y a une erreur ne pas executer la requête SQL.

On crée ensuite notre formulaire

### Ajout d'une ligne

Pour ajouter une ligne on va vérifier pour chaque donnée si elle est vraie (remplie) ou fausse, auquel cas on ne validera pas l'ajout dans la base de donnée.

On commence par vérifier si le champ n'est pas vide grâce à la condition ```if(count($_POST) > 0)``` ensuite on vérifie pour chaque élément dont on veut rentre obligatoire la complétion s'il n'est pas vide de la manière suivant :
```
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
```

Et si effectivement le code ne détecte pas d'erreurs on peut insérer les informations dans notre base de donnée en utilisant la requête ```$sql = 'INSERT INTO lightbulb(change_date, floor, position, power, brand) VALUES (:change_date, :floor, :position, :power, :brand)';```
On vient ensuite préparer cette requête et lié des paramètres aux différents champs renseigné afin de se protéger d'injection SQL :
```
        $sth = $pdo->prepare($sql);
        $sth->bindValue(':change_date', strftime("%Y-%m-%d", strtotime($change_date)), PDO::PARAM_STR);
        $sth->bindParam(':floor', $floor, PDO::PARAM_STR);
        $sth->bindParam(':position', $position, PDO::PARAM_STR);
        $sth->bindParam(':power', $power, PDO::PARAM_STR);
        $sth->bindParam(':brand', $brand, PDO::PARAM_STR);
        $sth->execute();
```
Si les informations rentrée son correctes et qu'il n'y a pas d'erreurs, on indique a notre page de nous rediriger sur la page index.php lorsque l'on clic sur le bouton "Ajouter".

### Modifier un ligne

On va se baser en grande partie sur le code pour ajouter sauf qu'on va placer en amont une condition qui ne sera valide que si on a cliqué sur modifier qui vas aller chercher les données entrées pour l'id sur laquelle on a cliquer sur modifier : ```$sql = 'SELECT id, change_date, floor, position, power, brand FROM lightbulb WHERE id=:id';```. Requête qu'on va préparer et on va attribuer un paramètre à l'id pour se protéger ```$id = htmlentities($_GET['id']);```.
On donne  attribue les données de la table a des variables pour pouvoir voir ce qu'elles sont et ainsi le modifier : 
```
        $change_date = $data['change_date'];
        $floor = $data['floor'];
        $position = $data['position'];
        $power = $data['power'];
        $brand = $data['brand'];
```
On repasse ensuite par notre condition pour vérifier le remplissage de toutes les données du formulaire jusqu'a la condition de si tout est rempli on onvoit les nouvelles informations à notre base de donnée : 
```
    if(isset($_POST['edit']) && ($_POST['id'])){
        $sql = 'UPDATE lightbulb SET change_date=:change_date, floor=:floor, position=:position, power=:power, brand=:brand WHERE id=:id';

```

