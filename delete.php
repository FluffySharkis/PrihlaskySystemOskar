<?php

include "inc/db-pdo.php"; 

$id = $_GET['id']; 
$sql = "DELETE FROM prihlaska WHERE  prihlaska_id='$id'";
$db->exec($sql);

header('Location: prihlasky.php');
exit();
