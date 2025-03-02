<?php

include "db-pdo.php"; 
$id = $_GET['id']; 
$sql = "DELETE FROM users WHERE  user_id='$id'";
    $db->exec($sql);
    header('Location: ../newuser.php');
    exit();