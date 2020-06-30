<?php
 require_once('db.php');

/* $user ="";
 $password ="";

if(isset($_POST['login'])){
    $sql = 'SELECT id, user, password FROM membre WHERE user=:user';
    $sth = $pdo->prepare($sql);
    $sth->execute();
    $result = $sth->fetch();
    $user = 
   
    if(isset($_POST['user'] == $user && $_POST['password'] == $password)){
        session_start();
        header('Location : index.php');
    }else{
        echo 'Accès refusé';
    }
}*/

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
     <title>Login</title>
 </head>
 <body>
    <form action="login.php" method ="post" id="login">
        <div>
            <label for="id">Identifiant :</label>
            <input type="text" id="user" name="user" placeholder="admin">
        </div>
        <div>
        <label for="pass">Mot de passe :</label>       
        <input type="text" id="password" name="password" placeholder="admin"> 
        </div>
        <input type="submit" value="login" name="login">
    
    </form>
     
 </body>
 </html>