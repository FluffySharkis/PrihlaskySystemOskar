<?php
// session_start();
session_start();
require_once 'db-pdo.php';


if (!empty($_SESSION['user_id'])) {
    $userQuery = $db->prepare('SELECT user_id FROM users WHERE user_id=:id AND active=1 LIMIT 1;');
    $userQuery->execute([
        ':id' => $_SESSION['user_id']
    ]);
    if ($userQuery->rowCount() != 1) {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        header('Location: index.php');
        exit();
    }
}
