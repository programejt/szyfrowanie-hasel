<?php
  if (isset($_POST['password'])) {
    $password = htmlentities($_POST['password'], ENT_QUOTES, "UTF-8");
    $passwordHash = password_hash($password , PASSWORD_BCRYPT);
    $showResult = true;
  } else {
    $password = "";
    $showResult = false;
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Szyfrowanie haseł</title>
    <link rel="stylesheet" href="resources/style.css">
    <script src="resources/main.js"></script>
  </head>
  <body>
    <div class="container">
      <form method="post">
        <div class="input-group input-title">Hasło</div>
        <div class="input-group input-wrapper"><input type="text" name="password" placeholder="Hasło" value="<?php echo $password ?>"></div>
        <div class="input-group button-wrapper"><button type="submit" class="btn btn-primary">Szyfruj</button></div>
      </form>
    </div>
    <?php if ($showResult) { ?>
      <div class="post-result container">
        <div class="input-group title-with-button">
          <div class="input-title">Zaszyfrowane hasło</div>
          <button type="button" class="close-btn" title="Zamknij">x</button>
        </div>
        <div class="input-group input-wrapper"><input type="text" name="post-result" value="<?php echo $passwordHash ?>" readonly></div>
        <div class="input-group button-wrapper"><button class="copy-btn btn btn-secondary">Kopiuj</button></div>
      </div>
    <?php } ?>
  </body>
</html>
