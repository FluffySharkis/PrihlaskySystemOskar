<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/prihlaska.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>

    <title>Tábor</title>
</head>

<body>
    <nav>
        <ul>
            <li>
                <a href="../index.php">Domů |</a>
            </li>
            <li>
                <a href="../registrace.php">Registrace admin |</a>
            </li>
            <?php
            require_once 'user.php';

            if (!empty($_SESSION['user_id'])) {
                echo '
        
            <li>
                <a href="../prihlasky.php">Přehled přihlášek |</a>
            </li>
            <li>
                <a href="../prehled.php"> Akceptace přihlášek |</a>
            </li>
            <li>
                <a href="../newuser.php"> Akceptace administrátorů |</a>
            </li>
            <li>
            <a href="../stav.php"> Statistika přihlášek </a>
            </li>';
            }
            ?>


        </ul>
    </nav>