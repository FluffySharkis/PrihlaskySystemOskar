<?php
include 'inc/header.php';
require_once 'inc/user.php';
if (!empty($_SESSION['user_id'])) {
  header('Location: prihlasky.php');
  exit();
}

$errors = false;
if (!empty($_POST)) {
  $userQuery = $db->prepare('SELECT * FROM users WHERE email=:email LIMIT 1;');
  $userQuery->execute([
    ':email' => trim($_POST['email'])
  ]);
  if ($user = $userQuery->fetch(PDO::FETCH_ASSOC)) {

    if (password_verify($_POST['password'], $user['password'])&&($user['akceptace']==true)) {
      $_SESSION['user_id'] = $user['user_id'];
      $_SESSION['user_name'] = $user['name'];
      $_SESSION['type'] = $user['type'];
      header('Location: prihlasky.php');
      exit();
    } else {
      $errors = true;
    }
  } else {
    $errors = true;
  }
}
?>

<h2 class="center">Přihlášení do administrativy</h2>
<form method="post">
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="email">E-mail:</label>
      <input type="text" name="email" id="email" required class="form-control <?php echo ($errors ? 'is-invalid' : ''); ?>" value="<?php echo htmlspecialchars(@$_POST['email']) ?>" />
      <?php
      echo ($errors ? '<div class="invalid-feedback">Neplatná kombinace přihlašovacího e-mailu a hesla.</div>' : '');
      ?>
    </div>
    <div class="form-group col-md-6">
      <label for="password">Heslo:</label>
      <input type="password" name="password" id="password" required class="form-control <?php echo ($errors ? 'is-invalid' : ''); ?>" />
    </div>
  </div>
  <div class="element-form-submit">
    <button type="submit" class="btn btn-primary btn-sm">Přihlásit se</button>
    <a href="forgotten-password.php" class="btn btn-secondary btn-sm">zapomněl(a) jsem heslo</a>
    <a href="index.php" class="btn btn-secondary btn-sm">Zrušit</a>
  </div>
</form>

<?php include 'inc/footer.php'; ?>