<?php include 'inc/header.php'; ?>

<?php

include "inc/db-pdo.php"; // Using database connection file here

$id = $_GET['id']; // get id through query string

$qry = $db->prepare('SELECT * FROM `dite` join prihlaska on (dite.id = prihlaska.dite_id) join turnus on (turnus.turnus_id = prihlaska.turnus_id) WHERE prihlaska_id = ?;');
$qry->execute(array("$id"));

$data = $qry->fetch(PDO::FETCH_ASSOC);

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
    if ($data['turnus_id']!=$_POST['turnus']){
        $qry = $db->prepare('SELECT * FROM prihlaska WHERE dite_id=:dite_id  and turnus_id=:turnus_id;');
        $qry->execute([
            ':dite_id' => $data['id'],
            ':turnus_id' => $_POST['turnus']
            ]);
        $dite = $qry->fetch(PDO::FETCH_ASSOC);    
        if (!empty($dite)){
        $chyby['turnus'] = 'Přihláška s tímto dítětem a turnusem již existuje!';
        }
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

        #region aktualizace existujícího příspěvku
        $saveQuery = $db->prepare('UPDATE dite SET jmeno=:jmeno, prijmeni=:prijmeni,narozeni=:narozeni, bydliste=:bydliste, psc=:psc, rjmeno=:rjmeno, rprijmeni=:rprijmeni, remail=:remail, rtelefon=:rtelefon, rjmeno2=:rjmeno2, rprijmeni2=:rprijmeni2, remail2=:remail2, rtelefon2=:rtelefon2 WHERE id=:id LIMIT 1;');
        $saveQuery->execute([
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
            ':rtelefon2'    => $_POST['rtelefon2'],
            ':id'           => $data['id']
        ]);

        /*Update turnus*/
        if (($data['turnus_id']==$_POST['turnus'])&&($data['odkud']==$_POST['odkud'])){
            header('Location: prihlasky.php');
            exit();
        }elseif(($data['turnus_id']!=$_POST['turnus'])&&($data['odkud']==$_POST['odkud'])){
            $qry = $db->prepare('SELECT * FROM prihlaska WHERE dite_id=:dite_id  and turnus_id=:turnus_id;');
            $qry->execute([
                ':dite_id' => $data['id'],
                ':turnus_id' => $_POST['turnus']
                ]);
            $dite = $qry->fetch(PDO::FETCH_ASSOC);    
            if (empty($dite)){
                $saveTurnusQuery = $db->prepare('UPDATE prihlaska SET turnus_id=:turnus_id, odkud=:odkud WHERE prihlaska_id=:id LIMIT 1;');
                $saveTurnusQuery->execute([
                    ':turnus_id'        => $_POST['turnus'],
                    ':odkud'        => $_POST['odkud'],
                    ':id'           => $id
                ]);
        
                header('Location: prihlasky.php');
                exit();
            }else{
                echo '<h5 style="color:#ee6172;">Přihláška s tímto turnusem a dítětem již existuje!</h5>';
            }
        }elseif(($data['turnus_id']==$_POST['turnus'])&&($data['odkud']!=$_POST['odkud'])){
            $saveOdkudQuery = $db->prepare('UPDATE prihlaska SET odkud=:odkud WHERE prihlaska_id=:id LIMIT 1;');
            $saveOdkudQuery->execute([
                    ':odkud'        => $_POST['odkud'],
                    ':id'           => $id
                ]);
        
                header('Location: prihlasky.php');
                exit();
        }else{
            $qry = $db->prepare('SELECT * FROM prihlaska WHERE dite_id=:dite_id  and turnus_id=:turnus_id;');
            $qry->execute([
                ':dite_id' => $data['id'],
                ':turnus_id' => $_POST['turnus']
                ]);
            $dite = $qry->fetch(PDO::FETCH_ASSOC);    
            if (empty($dite)){
                $saveTurnusQuery = $db->prepare('UPDATE prihlaska SET turnus_id=:turnus_id, odkud=:odkud WHERE prihlaska_id=:id LIMIT 1;');
                $saveTurnusQuery->execute([
                    ':turnus_id'        => $_POST['turnus'],
                    ':odkud'        => $_POST['odkud'],
                    ':id'           => $id
                ]);
        
                header('Location: prihlasky.php');
                exit();
            }else{
                echo '<h5 style="color:#ee6172;">Přihláška s tímto turnusem a dítětem již existuje!</h5>';
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

<h2 class="center">Aktualizace přihlášky <?php echo htmlspecialchars($data['jmeno']); ?> <?php echo htmlspecialchars($data['prijmeni']); ?></h2>

<form method="POST">
    <div class="container-form">
        <div class="edit-icon"><a href="prihlasky.php" onclick="return confirm('Opravdu chcete zrušit úpravy? Nebudou uloženy.')">
                <img src="img/cross.png" alt="Zrušit" width="20">

            </a></div>
        <h3 class="center"> Informace o dítěti:</h3>
        <!-- JMÉNO -->
        <div class="element-form">
            <label for="jmeno">* Jméno:</label>
            <input type="text" name="jmeno" id="jmeno" value="<?php if(!empty($_POST['jmeno'])){ echo htmlspecialchars($_POST['jmeno']);}else{ echo htmlspecialchars($data['jmeno']);} ?>" />
            <?php vypisChyby($chyby, 'jmeno'); ?>
        </div>
        <!-- PŘÍJMENÍ -->
        <div class="element-form">
            <label for="prijmeni">* Příjmení:</label>
            <input type="text" name="prijmeni" id="prijmeni" value="<?php if(!empty($_POST['prijmeni'])){ echo htmlspecialchars($_POST['prijmeni']);}else{echo htmlspecialchars($data['prijmeni']);} ?>" />
            <?php vypisChyby($chyby, 'prijmeni'); ?>
        </div>
        <!-- DATUM NAROZENÍ -->
        <div class="element-form">
            <label for="narozeni">* Datum narození:</label>
            <input type="date" name="narozeni" id="narozeni" value="<?php if(!empty($_POST['narozeni'])){ echo htmlspecialchars($_POST['narozeni']);}else{echo htmlspecialchars($data['narozeni']);} ?>" />
            <?php vypisChyby($chyby, 'narozeni'); ?>
        </div>
        <!-- BYDLIŠTĚ -->
        <div class="element-form">
            <label for="bydliste">* Bydliště:</label>
            <input type="text" name="bydliste" id="bydliste" value="<?php if(!empty($_POST['bydliste'])){ echo htmlspecialchars($_POST['bydliste']);}else{echo htmlspecialchars($data['bydliste']);} ?>" />
            <?php vypisChyby($chyby, 'bydliste'); ?>
        </div>
        <!-- PSČ -->
        <div class="element-form">
            <label for="psc">* PSČ:</label>
            <input type="number" name="psc" id="psc" value="<?php if(!empty($_POST['psc'])){ echo htmlspecialchars($_POST['psc']);}else{echo htmlspecialchars($data['psc']);} ?>" />
            <?php vypisChyby($chyby, 'psc'); ?>
        </div>
        <!-- TURNUS -->
        <div class="element-form">
            <label for="turnus">* Turnus:</label>
            <select name="turnus">
                <?php
                $year = date("Y");
                $turnusQuery = $db->prepare('SELECT * FROM turnus where rok=:rok;');
                $turnusQuery->execute([
                    ':rok' => $year
                ]);
                $turnusy = $turnusQuery->fetchAll(PDO::FETCH_ASSOC);
                echo '<option value="';
                echo  $data['turnus_id'];
                echo '">';
                echo htmlspecialchars($data['turnus']);
                echo '</option>';
                if (!empty($turnusy)) {
                    foreach ($turnusy as $turnus) {
                        echo '<option value="' . $turnus['turnus_id'] . '" ' . ($turnus['turnus_id'] == @$_POST['turnus'] ? 'selected="selected"' : '') . '>' . htmlspecialchars($turnus['turnus']) . '</option>';
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
            <input type="text" name="rjmeno" id="rjmeno" value="<?php if(!empty($_POST['rjmeno'])){ echo htmlspecialchars($_POST['rjmeno']);}else{echo htmlspecialchars($data['rjmeno']); }?>" />
            <?php vypisChyby($chyby, 'rjmeno'); ?>
        </div>
        <!-- PŘÍJMENÍ RODIČE -->
        <div class="element-form">
            <label for="rprijmeni">* Příjmení:</label>
            <input type="text" name="rprijmeni" id="rprijmeni" value="<?php if(!empty($_POST['rprijmeni'])){ echo htmlspecialchars($_POST['rprijmeni']);}else{ echo htmlspecialchars($data['rprijmeni']);} ?>" />
            <?php vypisChyby($chyby, 'rprijmeni'); ?>
        </div>
        <!-- EMAIL -->
        <div class="element-form">
            <label for="remail">* Email:</label>
            <input type="email" name="remail" id="remail" value="<?php if(!empty($_POST['remail'])){ echo htmlspecialchars($_POST['remail']);}else{echo htmlspecialchars($data['remail']);} ?>" />
            <?php vypisChyby($chyby, 'remail'); ?>
        </div>
        <!-- TELEFON -->
        <div class="element-form">
            <label for="rtelefon">* Telefon:</label>
            <input type="tel" name="rtelefon" id="rtelefon" value="<?php if(!empty($_POST['rtelefon'])){ echo htmlspecialchars($_POST['rtelefon']);}else{echo htmlspecialchars($data['rtelefon']);} ?>" />
            <?php vypisChyby($chyby, 'rtelefon'); ?>
        </div>
        <!-- Ročič 2 -->
        <h4>Rodič 2 </h4>
        <!-- JMÉNO RODIČE -->
        <div class="element-form">
            <label for="rjmeno2">* Jméno:</label>
            <input type="text" name="rjmeno2" id="rjmeno2" value="<?php if(!empty($_POST['rjmeno2'])){ echo htmlspecialchars($_POST['rjmeno2']);}else{echo htmlspecialchars($data['rjmeno2']);} ?>" />
            <?php vypisChyby($chyby, 'rjmeno2'); ?>
        </div>
        <!-- PŘÍJMENÍ RODIČE -->
        <div class="element-form">
            <label for="rprijmeni2">* Příjmení:</label>
            <input type="text" name="rprijmeni2" id="rprijmeni2" value="<?php if(!empty($_POST['rprijmeni2'])){ echo htmlspecialchars($_POST['rprijmeni2']);}else{echo htmlspecialchars($data['rprijmeni2']);} ?>" />
            <?php vypisChyby($chyby, 'rprijmeni2'); ?>
        </div>
        <!-- EMAIL -->
        <div class="element-form">
            <label for="remail2">* Email:</label>
            <input type="email" name="remail2" id="remail2" value="<?php if(!empty($_POST['remail2'])){ echo htmlspecialchars($_POST['remail2']);}else{echo htmlspecialchars($data['remail2']);} ?>" />
            <?php vypisChyby($chyby, 'remail2'); ?>
        </div>
        <!-- TELEFON -->
        <div class="element-form">
            <label for="rtelefon2">* Telefon:</label>
            <input type="tel" name="rtelefon2" id="rtelefon2" value="<?php if(!empty($_POST['rtelefon2'])){ echo htmlspecialchars($_POST['rtelefon2']);}else{echo htmlspecialchars($data['rtelefon2']);} ?>" />
            <?php vypisChyby($chyby, 'rtelefon2'); ?>
        </div>
        <!-- ODKUD SE O TÁBOŘE DOZVĚDĚLI -->
        <div class="element-form">
            <label for="odkud">Odkud jste se o táboře dozvěděli:</label>
            <input type="text" name="odkud" id="odkud" value="<?php if(!empty($_POST['odkud'])){ echo htmlspecialchars($_POST['odkud']);}else{echo htmlspecialchars($data['odkud']);} ?>" />

        </div>
        <div class="btn-my">
            <input type="submit" name="update" value="Aktualizovat přihlášku" onclick="return confirm('Opravdu chcete tento záznam trvale změnit?');" />
        </div>
    </div>
</form>

<?php include 'inc/footer.php'; ?>