<?php
//načteme připojení k databázi a inicializujeme session
require_once 'inc/user.php';

if (!empty($_SESSION['user_id'])) {
  //uživatel už je přihlášený, nemá smysl, aby se přihlašoval znovu
  header('Location: index.php');
  exit();
}

$errors = false;
if (!empty($_POST) && !empty($_POST['email'])) {
  #region zpracování formuláře
  $userQuery = $db->prepare('SELECT * FROM users WHERE email=:email LIMIT 1;');
  $userQuery->execute([
    ':email' => trim($_POST['email'])
  ]);
  if ($user = $userQuery->fetch(PDO::FETCH_ASSOC)) {
    //zadaný e-mail byl nalezen

    #region vygenerování kódu pro obnovu hesla
    $code = 'xx' . rand(100000, 993952); //rozhodně by tu mohlo být i kreativnější generování náhodného kódu :)

    //uložíme kód do databáze
    $saveQuery = $db->prepare('INSERT INTO forgotten_passwords (user_id, code) VALUES (:user, :code)');
    $saveQuery->execute([
      ':user' => $user['user_id'],
      ':code' => $code
    ]);

    //načteme uložený záznam z databáze
    $requestQuery = $db->prepare('SELECT * FROM forgotten_passwords WHERE user_id=:user AND code=:code ORDER BY forgotten_password_id DESC LIMIT 1;');
    $requestQuery->execute([
      ':user' => $user['user_id'],
      ':code' => $code
    ]);
    $request = $requestQuery->fetch(PDO::FETCH_ASSOC);

    //sestavíme odkaz pro mail
    $link = 'renew-password.php'; 
    $link .= '?user=' . $request['user_id'] . '&code=' . $request['code'] . '&request=' . $request['forgotten_password_id'];
    #endregion vygenerování kódu pro obnovu hesla

    #region poslání mailu pro obnovu hesla
    define('ADRESA', 'vecs00@vse.cz');

    $prijemce = ADRESA;
    $predmet  = 'Zapomenuté heslo';
    $zprava   = '<html>
                    <head><meta charset="utf-8" /></head>
                    <body>Pro obnovu hesla do Ukázkové aplikace klikněte na následující odkaz: <a href="'.htmlspecialchars($link).'">'.htmlspecialchars($link).'</a></body>
                </html>';
    $zprava = wordwrap($zprava, 70);

    $hlavicky = [
      'MIME-Version: 1.0',
      'Content-type: text/html; charset=utf-8',
      'From: ' . ADRESA,
      'Reply-To: ' . ADRESA,
      'X-Mailer: PHP/' . phpversion()
    ];

    $hlavicky = implode("\r\n", $hlavicky); 
    mail($prijemce, $predmet, $zprava, $hlavicky);


    #endregion poslání mailu pro obnovu hesla

    //přesměrování pro potvrzení
    header('Location: forgotten-password.php?mailed=ok');
  } else {
    //zadaný e-mail nebyl nalezen
    $errors = true;
  }
  #endregion zpracování formuláře
}

//vložíme do stránek hlavičku
include __DIR__ . '/inc/header.php';
?>

<h2>Obnova zapomenutého hesla</h2>
<?php
if (@$_GET['mailed'] == 'ok') {

  echo '<p>Zkontrolujte svoji e-mailovou schránku a klikněte na odkaz, který vám byl zaslán mailem.</p>';

  echo '<a href="index.php" class="btn btn-light">zpět na homepage</a>';
} else {
?>
  <form method="post">
    <div class="form-group">
      <label for="email">E-mail:</label>
      <input type="email" name="email" id="email" required class="form-control <?php echo ($errors ? 'is-invalid' : ''); ?>" value="<?php echo htmlspecialchars(@$_POST['email']) ?>" />
      <?php
      echo ($errors ? '<div class="invalid-feedback">Neplatný e-mail.</div>' : '');
      ?>
    <div class="element-form-submit">
    <button type="submit" class="btn btn-primary">zaslat e-mail k obnově hesla</button>
    <a href="login.php" class="btn btn-secondary" role="button">přihlásit se</a>
    <a href="index.php" class="btn btn-secondary" role="button">zrušit</a>
  </form>
<?php
}
?>
<div class="clear"></div>
<?php
//vložíme do stránek patičku
include __DIR__ . '/inc/footer.php';
