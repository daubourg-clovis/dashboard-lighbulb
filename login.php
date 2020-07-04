<?php
 require_once('db.php');


if(isset($_POST) && !empty($_POST['user']) && !empty($_POST['password'])){
    extract($_POST);
    $sql = 'SELECT id, user, pwd FROM membre WHERE user=:user';
    $sth = $pdo->prepare($sql);
    $sth->bindParam(':user', $user, PDO::PARAM_STR);
    $sth->execute();
    $result = $sth->fetch(PDO::FETCH_ASSOC);
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
    }


?>

 <!DOCTYPE html>
 <html lang="en">
 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="shortcut icon" href="medias/favicon.ico" type="image/x-icon">
     <link rel="icon" href="medias/favicon.ico" type="image/x-icon">
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
     <link rel="stylesheet" href="style.css">
     <title>Login</title>
 </head>
 <body>
     <div class="loginbox">
         <h1>BIENVENUE</h1>
         <form action="login.php" method ="post" id="login" class="vert-align">
             <div class="form-group row">
                 <div class="col-lg-4 col-sm-4 col-4">
                     <label for="id">Identifiant :</label>
                 </div>
                 <input type="text" id="user" name="user" placeholder="admin" class="width-log">
             </div>
             <div class="form-group row">
                 <div  class="col-lg-4 col-sm-4 col-4">
                     <label for="pass">Mot de passe :</label>      
                 </div>
             <input type="text" id="password" name="password" placeholder="admin" class="width-log"> 
             </div>
             <button type="submit"  id="btn-login"name="login" class="btn btn-primary btn-lg">LOGIN <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" id="login-arrow"><path d="M13.025 1l-2.847 2.828 6.176 6.176h-16.354v3.992h16.354l-6.176 6.176 2.847 2.828 10.975-11z"/></svg></button>
         
         </form>
          
     </div>
<script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

 </body>
 </html>