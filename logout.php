<?php
require_once('db.php');
session_start();

if(session_destroy()){
    header('Location: login.php');
    exit;
}
