<?php
include "inc/db-pdo.php";

$id = $_GET['id'];

if (!empty($id)) {
    $saveQuery = $db->prepare('UPDATE prihlaska SET akceptace=:akceptace WHERE prihlaska_id=:prihlaska_id LIMIT 1;');
    $saveQuery->execute([
        ':akceptace'        => true,
        ':prihlaska_id'     => $id
    ]);

    header('Location: prehled.php');
    exit();
}
