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
    <header id="header-index">
      <a href="logout.php"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M16 10v-5l8 7-8 7v-5h-8v-4h8zm-16-8v20h14v-2h-12v-16h12v-2h-14z"/></svg></a>
      </header>
      <div class="container">
        <h1 id="h1-index">Gestion des ampoules</h1>

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