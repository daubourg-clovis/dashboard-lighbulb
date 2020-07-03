<?php
    session_start();
    require_once('db.php');
    if(!isset($_SESSION['user'])){
        header('Location: login.php');
        exit;
    }
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
    
    <header id="header-index" >
    <!-- Nav  ----------------------------->
    <nav class="navbar navbar-expand-lg navbar-dark">
  <a class="navbar-brand" href="#" ><svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" id="svg-bulb"><path d="M6 3.083c0-.421.297-.801.734-.897 4.408-.97 4.575-.844 5.001-1.678.166-.322.497-.508.842-.508 1.443 0 1.128 2.504-1.117 3.032-.639.15-4.314.949-4.314.949-.586.129-1.146-.307-1.146-.898zm1.146 4.059l10.119-2.226c.439-.096.735-.476.735-.896 0-.587-.559-1.028-1.146-.898l-10.12 2.225c-.507.112-.825.604-.711 1.1s.617.807 1.123.695zm2.012 6.361v.497h-2.158v2.639c0 1.779 1.631 2.58 2 4.361h6c.375-1.753 2-2.585 2-4.361v-2.639h-2.157v-.958c0-.734.52-1.372 1.252-1.535l1.062-.291c.438-.096.734-.476.734-.896 0-.587-.559-1.028-1.146-.898l-1.259.344c-1.456.333-2.486 1.602-2.486 3.065v1.169h-2v-.689c0-1.627-.865-2.291-2.077-3.394l8.343-1.835c.438-.097.734-.476.734-.897 0-.59-.559-1.028-1.146-.898l-10.12 2.226c-.437.096-.734.476-.734.896 0 .292.131.494.344.707.843.843 2.814 1.68 2.814 3.387zm4.141 10.156c-.19.216-.465.341-.753.341h-1.093c-.288 0-.562-.125-.752-.341l-1.451-1.659h5.5l-1.451 1.659z"/></svg>Tableau de Bord</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">Gestion <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="edit.php">Ajouter</a>
      </li>
      <li class="nav-item" id="svg-end">
        </li>
      </ul>
    </div>
    <a href="logout.php"><svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" id="svg-disc"><path d="M16 10v-5l8 7-8 7v-5h-8v-4h8zm-16-8v20h14v-2h-12v-16h12v-2h-14z"/></svg></a>
  </nav>
      
      </div>
      </header>
      <div class="container">
        <h2 id="h2-index">Gestion des ampoules</h2>
        
        <div id="action-bar" class="">        
        <!-- Redirection  ajout ampoule  -->
        <div class="vert-align">
            <div id="btn-margin">
            <a href="edit.php" class="btn btn-primary btn-lg">Entrer un changement d'ampoule</a>
        <!-- Formulaire de recherche ------->
            <form action="index.php" method="post">
              <input type="text" id="search" name="search">
              <button type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M23.822 20.88l-6.353-6.354c.93-1.465 1.467-3.2 1.467-5.059.001-5.219-4.247-9.467-9.468-9.467s-9.468 4.248-9.468 9.468c0 5.221 4.247 9.469 9.468 9.469 1.768 0 3.421-.487 4.839-1.333l6.396 6.396 3.119-3.12zm-20.294-11.412c0-3.273 2.665-5.938 5.939-5.938 3.275 0 5.94 2.664 5.94 5.938 0 3.275-2.665 5.939-5.94 5.939-3.274 0-5.939-2.664-5.939-5.939z"/></svg></button>
              <button><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 0c-3.31 0-6.291 1.353-8.459 3.522l-2.48-2.48-1.061 7.341 7.437-.966-2.489-2.488c1.808-1.808 4.299-2.929 7.052-2.929 5.514 0 10 4.486 10 10s-4.486 10-10 10c-3.872 0-7.229-2.216-8.89-5.443l-1.717 1.046c2.012 3.803 6.005 6.397 10.607 6.397 6.627 0 12-5.373 12-12s-5.373-12-12-12z"/></svg></button>
            </form>
        </div>

      </div>
      <!-- Tableau d'affichage des données ----------->
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

                        $intlDateFormatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::SHORT, IntlDateFormatter::NONE);

                        //Preparation Requete
                          $sql = 'SELECT id, change_date, floor, position, power, brand FROM lightbulb ORDER BY change_date DESC';
                          $sth = $pdo->prepare($sql);
                          $sth->execute();
                          $datas = $sth->fetchAll(PDO::FETCH_ASSOC);

                      if(!isset($_POST['search'])){
                     
            
                        //Preparation formatage des dates 
                        
                        //Affichage des éléments
                        foreach($datas as $data){
                            echo '<tr class="tr-hover">';
                            echo '<td>'.$intlDateFormatter->format(strtotime($data['change_date'])).'</td>';
                            echo '<td>'.$data['floor'].'</td>';
                            echo '<td>'.$data['position'].'</td>';
                            echo '<td class="pw-content">'.$data['power'].'</td>';
                            echo '<td>'.$data['brand'].'</td>';
                            echo '<td class="svg-center"><a href="edit.php?edit=1&id='.$data['id'].'"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="edit"><path d="M14.078 4.232l-12.64 12.639-1.438 7.129 7.127-1.438 12.641-12.64-5.69-5.69zm-10.369 14.893l-.85-.85 11.141-11.125.849.849-11.14 11.126zm2.008 2.008l-.85-.85 11.141-11.125.85.85-11.141 11.125zm18.283-15.444l-2.816 2.818-5.691-5.691 2.816-2.816 5.691 5.689z"/></svg></a></td>';
                            echo '<td class="svg-center"><button data-target="#staticBackdrop" data-toggle="modal" data-id="'.$data['id'].'" id="btn-cross"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="delete"><path d="M23.954 21.03l-9.184-9.095 9.092-9.174-2.832-2.807-9.09 9.179-9.176-9.088-2.81 2.81 9.186 9.105-9.095 9.184 2.81 2.81 9.112-9.192 9.18 9.1z"/></svg></button></td>';
                            echo '</tr>';
                        }
                      }else{
                        //$searchValue = $_POST['search'];
                        $sql = 'SELECT  id, change_date, floor, position, brand, power FROM lightbulb WHERE change_date LIKE :search OR floor LIKE :search OR position LIKE :search OR brand LIKE :search OR power LIKE :search';                        
                        $sth = $pdo->prepare($sql);
                        $sth->bindValue(':search', '%'.$_POST['search'].'%', PDO::PARAM_STR);
                        $sth->execute(); 
                        $datas = $sth->fetchAll(PDO::FETCH_ASSOC) ;                    
                        
                        foreach($datas as $data){
                          echo '<tr class="tr-hover">';
                          echo '<td>'.$intlDateFormatter->format(strtotime($data['change_date'])).'</td>';
                          echo '<td>'.$data['floor'].'</td>';
                          echo '<td>'.$data['position'].'</td>';
                          echo '<td class="pw-content">'.$data['power'].'</td>';
                          echo '<td>'.$data['brand'].'</td>';
                          echo '<td class="svg-center"><a href="edit.php?edit=1&id='.$data['id'].'"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="edit"><path d="M14.078 4.232l-12.64 12.639-1.438 7.129 7.127-1.438 12.641-12.64-5.69-5.69zm-10.369 14.893l-.85-.85 11.141-11.125.849.849-11.14 11.126zm2.008 2.008l-.85-.85 11.141-11.125.85.85-11.141 11.125zm18.283-15.444l-2.816 2.818-5.691-5.691 2.816-2.816 5.691 5.689z"/></svg></a></td>';
                          echo '<td class="svg-center"><button data-target="#staticBackdrop" data-toggle="modal" data-id="'.$data['id'].'" id="btn-cross"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="delete"><path d="M23.954 21.03l-9.184-9.095 9.092-9.174-2.832-2.807-9.09 9.179-9.176-9.088-2.81 2.81 9.186 9.105-9.095 9.184 2.81 2.81 9.112-9.192 9.18 9.1z"/></svg></button></td>';
                          echo '</tr>';
                        }
                      }                 
                      
                    ?>
                </table>
                <div id="btn-end">
                <a href="edit.php" class="btn btn-primary btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" id="add"><path d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm6 13h-5v5h-2v-5h-5v-2h5v-5h2v5h5v2z"/></svg></a>
                </div>
            </div>
    </div>

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
  </div>
  <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  <script src="deletecheck.js"></script>
</body>
</html>