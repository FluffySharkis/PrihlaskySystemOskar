<?php
include "inc/db-pdo.php";

$id = $_GET['id'];
$rodic = $_GET['rodic'];

$qry = $db->prepare('SELECT * FROM `dite` join prihlaska on (dite.id = prihlaska.dite_id) WHERE prihlaska_id = ?;');
$qry->execute(array("$id"));

$data = $qry->fetch(PDO::FETCH_ASSOC);
$email = "";

if ($rodic == 1) {
    $email = $data['remail'];
} else {
    $email = $data['remail2'];
}

define('ADRESA', $email);

$prijemce = ADRESA;
$predmet  = 'Přijatá žádost - tábor Oskar';
$zprava   = "<html>
                    <head>
                    <title>Přijatá žádost</title>
                    </head>
                    <body>
                    Dobrý den,<br />
                    zaevidovali jsme Vaši přihlášku na letní dětský tábor Oskar.<br />
                    Jméno dítěte: {$data['jmeno']} {$data['prijmeni']}, turnus: {$data['turnus']}.<br />
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

if (mail($prijemce, $predmet, $zprava, $hlavicky)) {
    $updateQuery = $db->prepare('UPDATE prihlaska SET korespondence=:korespondence WHERE prihlaska_id=:prihlaska_id LIMIT 1;');
    $updateQuery->execute([
        ':korespondence'        => true,
        ':prihlaska_id'     => $id
    ]);

    echo 'E-mail byl odeslán.';
    header('Location: prehled.php');
    exit();
} else {
    echo 'E-mail nebyl odeslán.';
}
