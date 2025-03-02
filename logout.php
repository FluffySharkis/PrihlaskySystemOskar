<?php
require_once 'inc/user.php';

if (!empty($_SESSION['user_id'])) {
    unset($_SESSION['user_id']);
    unset($_SESSION['user_name']);
    unset($_SESSION['type']);
}

header('Location: index.php');
exit();
