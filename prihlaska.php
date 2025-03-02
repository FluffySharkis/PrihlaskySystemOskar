<?php

include 'inc/header.php';

/*REGION KONTROLA */
$chyby = [];

if (!empty($_POST)) {
    $_POST['jmeno'] = trim(@$_POST['jmeno']);
    if (empty($_POST['jmeno'])) {
        $chyby['jmeno'] = 'Je nutné zadat jméno!';
    }

    $_POST['prijmeni'] = trim(@$_POST['prijmeni']);
    if (empty($_POST['prijmeni'])) {
        $chyby['prijmeni'] = 'Je nutné zadat příjmení! ';
    }

    $_POST['narozeni'] = trim(@$_POST['narozeni']);
    if (strtotime($_POST['narozeni']) >= (time() - (60 * 60 * 24 * 365 * 6))) {
        $chyby['narozeni'] = 'Ditěte neodpovídá věku dětí na táboře.';
    }
    if (empty($_POST['narozeni'])) {
        $chyby['narozeni'] = 'Je nutné zadat datum narození.';
    }
    if (empty($_POST['bydliste'])) {
        $chyby['bydliste'] = 'Je nutné zadat Bydliště. Bydliště obsahuje ulici, číslo popisné a město.';
    }


    $_POST['psc'] = trim(@$_POST['psc']);
    if (!preg_match('/^(\d{3})\s*(\d{2})$/', $_POST['psc'])) {
        $chyby['psc'] = 'Je nutné zadat PSČ. PSČ obsahuje pět číslic.';
    }
    if (empty($_POST['turnus'])) {
        $chyby['turnus'] = 'Vyberte si turnus.';
    }
    $_POST['rjmeno'] = trim(@$_POST['rjmeno']);
    if (empty($_POST['rjmeno'])) {
        $chyby['rjmeno'] = 'Je nutné zadat jméno rodiče!';
    }

    $_POST['rprijmeni'] = trim(@$_POST['rprijmeni']);
    if (empty($_POST['rprijmeni'])) {
        $chyby['rprijmeni'] = 'Je nutné zadat příjmení rodiče!';
    }

    $_POST['remail'] = trim(@$_POST['remail']);
    $_POST['rtelefon'] = str_replace([' ', '-', '/'], '', trim($_POST['rtelefon']));

    if ($_POST['remail'] != '' && !filter_var($_POST['remail'], FILTER_VALIDATE_EMAIL)) {
        $chyby['remail'] = 'Zadaný e-mail není platný!';
    }
    if (empty($_POST['remail'])) {
        $chyby['remail'] = 'Je nutné zadat kontakntí mail!';
    }
    if (empty($_POST['rtelefon'])) {
        $chyby['rtelefon'] = 'Je nutné zadat telefonní číslo!';
    }
    if ($_POST['rtelefon'] != '' && !preg_match("/^[0-9]{9}$/", $_POST['rtelefon'])) {
        $chyby['rtelefon'] = 'Zadaný telefon není platný!';
    }

    $_POST['rjmeno2'] = trim(@$_POST['rjmeno2']);
    if (empty($_POST['rjmeno2'])) {
        $chyby['rjmeno2'] = 'Je nutné zadat jméno rodiče!';
    }

    $_POST['rprijmeni2'] = trim(@$_POST['rprijmeni2']);
    if (empty($_POST['rprijmeni2'])) {
        $chyby['rprijmeni2'] = 'Je nutné zadat příjmení rodiče!';
    }

    $_POST['remail2'] = trim(@$_POST['remail2']);
    $_POST['rtelefon2'] = str_replace([' ', '-', '/'], '', trim($_POST['rtelefon2']));

    if ($_POST['remail2'] != '' && !filter_var($_POST['remail2'], FILTER_VALIDATE_EMAIL)) {
        $chyby['remail2'] = 'Zadaný e-mail není platný!';
    }
    if (empty($_POST['remail2'])) {
        $chyby['remail2'] = 'Je nutné zadat kontakntí mail!';
    }
    if (empty($_POST['rtelefon2'])) {
        $chyby['rtelefon2'] = 'Je nutné zadat telefonní číslo!';
    }
    if ($_POST['rtelefon2'] != '' && !preg_match("/^[0-9]{9}$/", $_POST['rtelefon2'])) {
        $chyby['rtelefon2'] = 'Zadaný telefon není platný!';
    }


    if (empty($_POST['odkud'])) {
        $chyby['odkud'] = 'Prosím, vyplňte odkud jste se o táboře dozvěděli.';
    }

    /*ENDREGION KONTROLA*/

    if (empty($chyby)) {
        include 'inc/db-pdo.php';

        if (!empty($_POST)) {
            $diteQuery = $db->prepare('SELECT id FROM dite where jmeno=:jmeno and prijmeni=:prijmeni and narozeni=:narozeni and rjmeno=:rjmeno and rprijmeni=:rprijmeni and rjmeno2=:rjmeno2 and rprijmeni2=:rprijmeni2;');
            $diteQuery->execute([
                ':jmeno'        => $_POST['jmeno'],
                ':prijmeni'     => $_POST['prijmeni'],
                ':narozeni'     => $_POST['narozeni'],
                ':rjmeno'       => $_POST['rjmeno'],
                ':rprijmeni'    => $_POST['rprijmeni'],
                ':rjmeno2'      => $_POST['rjmeno2'],
                ':rprijmeni2'   => $_POST['rprijmeni2']
            ]);
            $dite = $diteQuery->fetch(PDO::FETCH_ASSOC);

            if (empty($dite['id'])) {
                $queryDite = $db->prepare('INSERT INTO dite (jmeno, prijmeni,narozeni, bydliste, psc, rjmeno, rprijmeni, remail, rtelefon, rjmeno2, rprijmeni2, remail2, rtelefon2) 
                                        VALUES (:jmeno, :prijmeni,:narozeni, :bydliste, :psc, :rjmeno, :rprijmeni, :remail, :rtelefon, :rjmeno2, :rprijmeni2, :remail2, :rtelefon2)');
                $queryDite->execute([
                    ':jmeno'        => $_POST['jmeno'],
                    ':prijmeni'     => $_POST['prijmeni'],
                    ':narozeni'     => $_POST['narozeni'],
                    ':bydliste'     => $_POST['bydliste'],
                    ':psc'          => $_POST['psc'],
                    ':rjmeno'       => $_POST['rjmeno'],
                    ':rprijmeni'    => $_POST['rprijmeni'],
                    ':remail'       => $_POST['remail'],
                    ':rtelefon'     => $_POST['rtelefon'],
                    ':rjmeno2'      => $_POST['rjmeno2'],
                    ':rprijmeni2'   => $_POST['rprijmeni2'],
                    ':remail2'      => $_POST['remail2'],
                    ':rtelefon2'    => $_POST['rtelefon2']
                ]);
                $query = $db->query('SELECT LAST_INSERT_ID() AS id;');
                $last = $query->fetch(PDO::FETCH_ASSOC);

                $queryPrihlaska = $db->prepare('INSERT INTO prihlaska (turnus_id, dite_id, odkud) 
                                             VALUES (:turnus_id, :dite_id,:odkud)');
                $queryPrihlaska->execute([
                    ':turnus_id'        => $_POST['turnus'],
                    ':dite_id'     => $last['id'],
                    ':odkud'     => $_POST['odkud']
                ]);
                header('Location: success.php');
                exit();
            } else {
                /*ID dítěte již existuje */
                $prihlaskaQuery = $db->prepare('SELECT prihlaska_id FROM `prihlaska` where dite_id=:dite_id and turnus_id=:turnus_id;');
                $prihlaskaQuery->execute([
                    ':dite_id'        => $dite['id'],
                    ':turnus_id'     => $_POST['turnus']
                ]);
                $prihlaska = $prihlaskaQuery->fetch(PDO::FETCH_ASSOC);

                if (empty($prihlaska['prihlaska_id'])) {

                    $queryPrihlaska = $db->prepare('INSERT INTO prihlaska (turnus_id, dite_id, odkud) 
                                             VALUES (:turnus_id, :dite_id,:odkud)');
                    $queryPrihlaska->execute([
                        ':turnus_id'        => $_POST['turnus'],
                        ':dite_id'     => $dite['id'],
                        ':odkud'     => $_POST['odkud']
                    ]);
                    header('Location: success.php');
                    exit();
                } else {
                    echo '<h5 style="color:#ee6172;">Tato přihláška je již evidovaná! </h5>';
                }
            }
        }
    }
}
function vypisChyby(array $chyby, $id)
{
    if (!empty($chyby[$id])) {
        echo '<div style="color:#ee6172;">' . $chyby[$id] . '</div>';
    }
}
?>
<h2 class="center">Přihláška na letní dětský tábor</h2>

<form method="post">
    <div class="container-form">
        <div class="edit-icon"><a href="index.php" onclick="return confirm('Opravdu chcete opustit formulář? Data nebudou uloženy.')">
                <img src="img/cross.png" alt="Zrušit" width="20">

            </a></div>
        <h3 class="center"> Informace o dítěti:</h3>
        <!-- JMÉNO -->
        <div class="element-form">
            <label for="jmeno">* Jméno:</label>
            <input type="text" name="jmeno" id="jmeno" value="<?php echo htmlspecialchars(@$_POST['jmeno']); ?>" />
            <?php vypisChyby($chyby, 'jmeno'); ?>
        </div>
        <!-- PŘÍJMENÍ -->
        <div class="element-form">
            <label for="prijmeni">* Příjmení:</label>
            <input type="text" name="prijmeni" id="prijmeni" value="<?php echo htmlspecialchars(@$_POST['prijmeni']); ?>" />
            <?php vypisChyby($chyby, 'prijmeni'); ?>
        </div>
        <!-- DATUM NAROZENÍ -->
        <div class="element-form">
            <label for="narozeni">* Datum narození:</label>
            <input type="date" name="narozeni" id="narozeni" value="<?php echo htmlspecialchars(@$_POST['narozeni']); ?>" />
            <?php vypisChyby($chyby, 'narozeni'); ?>
        </div>
        <!-- BYDLIŠTĚ -->
        <div class="element-form">
            <label for="bydliste">* Bydliště:</label>
            <input type="text" name="bydliste" id="bydliste" value="<?php echo htmlspecialchars(@$_POST['bydliste']); ?>" />
            <?php vypisChyby($chyby, 'bydliste'); ?>
        </div>
        <!-- PSČ -->
        <div class="element-form">
            <label for="psc">* PSČ:</label>
            <input type="number" name="psc" id="psc" value="<?php echo htmlspecialchars(@$_POST['psc']); ?>" />
            <?php vypisChyby($chyby, 'psc'); ?>
        </div>
        <!-- TURNUS -->
        <div class="element-form">
            <label for="turnus">* Turnus:</label>
            <select name="turnus">
                <option value="">--</option>
                <?php
                $year = date("Y");
                $turnusQuery = $db->prepare('SELECT * FROM turnus where rok=:rok;');
                $turnusQuery->execute([
                    ':rok' => $year
                ]);
                $turnusy = $turnusQuery->fetchAll(PDO::FETCH_ASSOC);
                if (!empty($turnusy)) {
                    foreach ($turnusy as $turnus) {
                        $pocetQuery = $db->prepare('SELECT COUNT(prihlaska_id) AS pocet FROM prihlaska WHERE turnus_id=:turnus_id');
                        $pocetQuery->execute([
                            ':turnus_id'        => $turnus['turnus_id']
                        ]);
                        $pocet =  $pocetQuery->fetch(PDO::FETCH_ASSOC);

                        if ($pocet['pocet'] >= $turnus['max']) {
                            echo '<option value ="">'. htmlspecialchars($turnus['turnus']) . ' - obsazeno</option>';
                        } else {

                            echo '<option value="' . $turnus['turnus_id'] . '" ' . ($turnus['turnus_id'] == @$_POST['turnus'] ? 'selected="selected"' : '') . '>' . htmlspecialchars($turnus['turnus']) . '</option>';
                        }
                    }
                }

                ?>
            </select>
            <?php vypisChyby($chyby, 'turnus'); ?>
        </div>

        <h3 class="center">Informace o rodičích:</h3>

        <!-- Ročič 1 -->
        <h4>Rodič 1 </h4>
        <!-- JMÉNO RODIČE -->
        <div class="element-form">
            <label for="rjmeno">* Jméno:</label>
            <input type="text" name="rjmeno" id="rjmeno" value="<?php echo htmlspecialchars(@$_POST['rjmeno']); ?>" />
            <?php vypisChyby($chyby, 'rjmeno'); ?>
        </div>
        <!-- PŘÍJMENÍ RODIČE -->
        <div class="element-form">
            <label for="rprijmeni">* Příjmení:</label>
            <input type="text" name="rprijmeni" id="rprijmeni" value="<?php echo htmlspecialchars(@$_POST['rprijmeni']); ?>" />
            <?php vypisChyby($chyby, 'rprijmeni'); ?>
        </div>
        <!-- EMAIL -->
        <div class="element-form">
            <label for="remail">* Email:</label>
            <input type="email" name="remail" id="remail" value="<?php echo htmlspecialchars(@$_POST['remail']); ?>" />
            <?php vypisChyby($chyby, 'remail'); ?>
        </div>
        <!-- TELEFON -->
        <div class="element-form">
            <label for="rtelefon">* Telefon:</label>
            <input type="tel" name="rtelefon" id="rtelefon" value="<?php echo htmlspecialchars(@$_POST['rtelefon']); ?>" />
            <?php vypisChyby($chyby, 'rtelefon'); ?>
        </div>

        <!-- Ročič 2 -->
        <h4>Rodič 2 </h4>
        <!-- JMÉNO RODIČE -->
        <div class="element-form">
            <label for="rjmeno2">* Jméno:</label>
            <input type="text" name="rjmeno2" id="rjmeno2" value="<?php echo htmlspecialchars(@$_POST['rjmeno2']); ?>" />
            <?php vypisChyby($chyby, 'rjmeno2'); ?>
        </div>
        <!-- PŘÍJMENÍ RODIČE -->
        <div class="element-form">
            <label for="rprijmeni2">* Příjmení:</label>
            <input type="text" name="rprijmeni2" id="rprijmeni2" value="<?php echo htmlspecialchars(@$_POST['rprijmeni2']); ?>" />
            <?php vypisChyby($chyby, 'rprijmeni2'); ?>
        </div>
        <!-- EMAIL -->
        <div class="element-form">
            <label for="remail2">* Email:</label>
            <input type="email" name="remail2" id="remail2" value="<?php echo htmlspecialchars(@$_POST['remail2']); ?>" />
            <?php vypisChyby($chyby, 'remail2'); ?>
        </div>
        <!-- TELEFON -->
        <div class="element-form">
            <label for="rtelefon2">* Telefon:</label>
            <input type="tel" name="rtelefon2" id="rtelefon2" value="<?php echo htmlspecialchars(@$_POST['rtelefon2']); ?>" />
            <?php vypisChyby($chyby, 'rtelefon2'); ?>
        </div>
        <!-- ODKUD SE O TÁBOŘE DOZVĚDĚLI -->
        <div class="element-form">
            <label for="odkud">* Odkud jste se o táboře dozvěděli:</label>
            <input type="text" name="odkud" id="odkud" value="<?php echo htmlspecialchars(@$_POST['odkud']); ?>" />
            <?php vypisChyby($chyby, 'odkud'); ?>
        </div>
        <div class="btn-my">
            <input type="submit" name="pridat" value="Odeslat přihlášku" />
        </div>
    </div>
</form>
<div class="clear"></div>
<?php include 'inc/footer.php'; ?>