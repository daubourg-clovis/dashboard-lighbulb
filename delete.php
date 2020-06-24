<?php
    require_once('db.php');

    if(isset($_GET['id'])){
        $sql = 'DELETE FROM lightbulb WHERE id=:id';
        $sth = $pdo->prepare($sql);
        $sth->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
        $sth->execute();

    }

    header('Location: index.php');