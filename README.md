# Création d'un dashboard pour un gardien d'immeuble devant gérer le changement des ampoules du bâtiment

On configure d'abord la connection à la base de donnée

## Affichage des données :

On créer une page index.php et on y inclut notre connection à la base de donnée.

On met en place un tableau avec l'entête des colonnes en html et le corps de ces colonnes en php, qui seront crées et remplies par les informations de notre base de donnée.

Pour cela on fait d'abord une requête SQL ``` $sql = 'SELECT id, change_date, floor, position, power, brand FROM lightbulb';``` qu'on prépare afin de se protéger des injections SQL.
On va ensuite mettre les données dans un tableau php ```$datas = $sth->fetchAll(PDO::FETCH_ASSOC);``` afin de pouvoir les insérer dans notre tableau.
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


## Suppression d'une ligne 

Dans un fichier séparé delete.php qu'on a lié à notre à notre page dans notre tableau on fait le code php suivant pour pouvoir supprimer une ligne
Dans un premier temps on la lie aussi a notre page de connection à le base de données pour que l'action de la requête SQL de suppression puisse se faire.
On précise dans un premier temps qu'on veut supprimer seulement sur lequel on a cliqué pour se faire avant de faire notre requête on l'inclut dans un ```if(isset($_GET['id']))``` puis ont fait notre requête sans oublier de la préparer avec l'aide d'un marqueur ```:id``` auquel on attribue la valeur ```$_GET['id']```. IN lui lie aussi le statement ```PDO::PARAM_INT``` pour préciser que l'id est un chiffre entier, ce qui nous sert de protection.
```
    $sql = 'DELETE FROM lightbulb WHERE id=:id';
    $sth = $pdo->prepare($sql);
    $sth->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $sth->execute();

```

On ajoute après notre condition if la ligne ```header('Location: index.php');``` pour lui dire de nous rediriger directement sur la page index.php ce qui aura pour effet de ne pas nous faire changer de page si la requête de suppression s'execute bien.

## Ajout/Modification d'une ligne 

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


## Création d'une page de login

### La page login.php

On créer dans notre base de donnée une table pour contenir notre utilisateur et son mot de passe qui pour l'exemple seront admin et admin et déjà inséré en dur dans la bd (pas de hash)

On vérifie déjà si l'on reçoit bien notre formulaire de login  et que les champs de sont pas vides ```if(isset($_POST) && !empty($_POST['user']) && !empty($_POST['password']))``` on fait ensuite notre requête SQL pour récupérer  les données de la base de donnée ```'SELECT id, user, pwd FROM membre WHERE user=:user'``` on pépare la requête pour se prémunir d'éventuelles injection SQL et on récupère les résultats où le nom de l'utilisateur indiqué dans le formulaire correspond a celui de la bdd.

On vérifie si le résultat n'est pas booléen pour ne pas avoir d'erreur dans le PHP (ce qui sera le cas si les données du formulaire ne sont pas dans la bdd) ```if(gettype($result) !== 'boolean')```.

On va ensuite comparer le mot passe avec celui indiqué dans la formulaire de login correspondant à l'utilisateur indiqué ```if($result['pwd'] == $password)```.

Si l'utilisateur et le mot de passe correspondent on démarre le session et on l'attribue à l'utilisateur  puis on le redirige vers notre page index.php. Sinon on lui dit que l'accès et refusé et il doit à nouveau taper un mot de passe et un identifiant ou il ne sera pas redirigé sur le page principale.

```
    if(gettype($result) !== 'boolean'){
        if($result['pwd'] == $password){
            session_start();
            $_SESSION['user'] = $user;
            header('Location: index.php');
            exit;
        }else{
            echo 'Accès refusé';
        }
    }
```

### Sur la page index.php

On démarre le session et on vérifie si elle est bien attribuée à un utilisateur, si elle ne l'est pas on rediriger vers la page login.php 

```
    session_start();
    require_once('db.php');
    if(!isset($_SESSION['user'])){
        header('Location: login.php');
        exit;
    }
```

### La page logout.php

On démarre la session et si elle est détruite on redirige sur la page login.php. La destruction de la session se fait lor du clic sur un lien de la page index.php

```
require_once('db.php');
session_start();

if(session_destroy()){
    header('Location: login.php');
    exit;
}

```

## Création du CSS avec l'aide de bootstrap
    Utilisation de la grille, des preset de base de bootstrap pour le tableau et les boutons. Mise en place d'icônes pour modifier/supprimer/se déconnecter



## Amélioration du modal de vérification de suppression avec bootstrap

J'avais au début fait une vérification de suppression utilisant la fonction Javascript ```confirm()``` qui utilise la fenêtre par défaut du navigateur. Pour le projet on m'a demandé de faire moi-même cette fenêtre et donc le code correspondant pour que cela corresponde aux graphismes du site. J'ai donc utilise le modal de bootstrap 
```
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content bg-modal">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Supprimer</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true" class="cancel">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Êtes vous sur de vouloir supprimer ?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
            <button id="btn-delete" class="btn btn-danger">SUPPRIMER</button>
          </div>
        </div>
      </div>
```

que j'ai réadapté pour qu'il redirige sur delete.php grâce au code suivant 
```<button data-target="#staticBackdrop" data-toggle="modal" data-id="'.$data['id'].'" id="btn-cross"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="delete"><path d="M23.954 21.03l-9.184-9.095 9.092-9.174-2.832-2.807-9.09 9.179-9.176-9.088-2.81 2.81 9.186 9.105-9.095 9.184 2.81 2.81 9.112-9.192 9.18 9.1z"/></svg></button>``` dans le html pour le lier à la page deletecheck.js et au modalgit commit .

Comme j'ai utilisé bootstrap qui utilise jquery, j'ai également utilisé jquery pour gérer le modal : 
```
deleteId = 0;
$('#staticBackdrop').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    deleteId = button[0].dataset.id;
    });

$('#btn-delete').click(function(){
    $(location).attr('href', 'delete.php?id='+deleteId);
});
```