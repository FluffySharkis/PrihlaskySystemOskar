<?php

use Mpdf\Tag\B;

include "db-pdo.php";

$id_user = $_GET['id'];
$saveQuery = $db->prepare('UPDATE users SET akceptace=1 WHERE user_id=:id LIMIT 1;');
$saveQuery->execute([
    ':id'        => $id_user
]);


$qry = $db->prepare('SELECT * FROM `users` WHERE user_id = ?;');
$qry->execute(array("$id_user"));

$data = $qry->fetch(PDO::FETCH_ASSOC);
$email = $data['email'];

if ($data['akceptace']==true){
define('ADRESA', $email);

$prijemce = ADRESA;
$predmet  = 'Založený účet';
$zprava   = "<html>
                    <head>
                    <title>Založený účet</title>
                    </head>
                    <body>
                    Dobrý den,<br />
                    váš účet byl schválený. Již jej můžete používat.<br />
                    Název: {$data['name']}<br />
                    S přáním hezkého dne Oskar
                    </body>
            </html>";
$zprava = wordwrap($zprava, 70);

$hlavicky = [
    'MIME-Version: 1.0',
    'Content-type: text/html; charset=utf-8',
    'From: ' . ADRESA,
    'Reply-To: ' . ADRESA,
    'X-Mailer: PHP/' . phpversion()
];

$hlavicky = implode("\r\n", $hlavicky); //co dělá funkce implode? - vrací string pro elementy pole
mail($prijemce, $predmet, $zprava, $hlavicky);
}
header('Location: ../newuser.php');
exit();
