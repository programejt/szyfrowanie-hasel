<?php
  const SALT_BEFORE_PASSWORD = 1;
  const SALT_AFTER_PASSWORD = 2;
  const PAGE_TITLE = 'Szyfrowanie hasła';

  $salt = "";
  $saltBytes = 16;
  $showSaltFieldset = isset($_POST['enable-salt']);
  $saltPosition = match ((int) $_POST['salt-position']) {
    SALT_AFTER_PASSWORD => SALT_AFTER_PASSWORD,
    default => SALT_BEFORE_PASSWORD
  };

  if (isset($_POST['password'])) {
    $password = $_POST['password'];

    if (isset($_POST['salt-bytes'])) {
      $saltBytes = (int) $_POST['salt-bytes'];

      if ($saltBytes > 0 && $saltBytes < 100) {
        $salt = bin2hex(random_bytes($saltBytes));

        if ($saltPosition == SALT_BEFORE_PASSWORD) {
          $password = $salt.$password;
        } else {
          $password .= $salt;
        }
      }
    }

    $passwordHash = password_hash($password , PASSWORD_BCRYPT);
    $password = htmlentities($_POST['password'], ENT_QUOTES, 'utf-8');
    $showResult = true;
  } else {
    $showResult = false;
    $password = '';
  }

  function saltPositionCheckedStatus($value): void {
    global $saltPosition;
    echo $saltPosition == $value ? 'checked' : '';
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title><?php echo PAGE_TITLE ?></title>
    <link rel="icon" type="image/x-icon" href="favicon.png">
    <link rel="stylesheet" href="resources/fontawesome-free-web/css/fontawesome.min.css">
    <link rel="stylesheet" href="resources/fontawesome-free-web/css/solid.min.css">
    <link rel="stylesheet" href="resources/fontawesome-free-web/css/brands.min.css">
    <link rel="stylesheet" href="resources/fontawesome-free-web/css/regular.min.css">
    <link rel="stylesheet" href="resources/style.css">
    <script src="resources/main.js"></script>
  </head>
  <body>
    <h1 class="ta-center"><?php echo PAGE_TITLE ?></h1>
    <div class="container">
      <form method="post">
        <div class="container-small">
          <div class="input-title">Hasło</div>
          <div class="custom-input input-password"><input type="password" name="password" value="<?php echo $password ?>" placeholder="Hasło" required><button type="button" class="toggle-password-visibility" title="Przełącz widoczność znaków"><i class="icon input-icon"></i></button></div>
        </div>
        <div class="container-small ta-center">
          <div><label><input type="checkbox" name="enable-salt" id="enable-salt-checkbox" <?php echo $showSaltFieldset ? 'checked' : '' ?>><span class="input-label"><i class="icon input-icon"></i> Dodaj sól</span></label></div>
        </div>
        <fieldset id="password-salt" class="form-section hidden" disabled>
          <div class="container-small">
            <div class="input-title">Ilość bajtów soli</div>
            <div><input type="number" min="1" max="99" step="1" name="salt-bytes" placeholder="Ilość bajtów soli" value="<?php echo $saltBytes ?>"></div>
          </div>
          <div class="container-small">
            <div class="input-title">Wstaw sól</div>
            <div>
              <label><input type="radio" name="salt-position" value="<?php echo SALT_BEFORE_PASSWORD ?>" <?php saltPositionCheckedStatus(SALT_BEFORE_PASSWORD) ?>><span class="input-label"><i class="icon input-icon"></i> Przed hasłem</span></label>
              <label><input type="radio" name="salt-position" value="<?php echo SALT_AFTER_PASSWORD ?>" <?php saltPositionCheckedStatus(SALT_AFTER_PASSWORD) ?>> <span class="input-label"><i class="icon input-icon"></i> Za hasłem</span></label>
            </div>
          </div>
        </fieldset>
        <div class="container-small ta-center"><button type="submit" class="btn btn-primary">Szyfruj</button></div>
      </form>
    </div>

    <?php if ($showResult) { ?>
      <div class="post-result container">
        <header class="ta-right">
          <button type="button" class="close-btn" title="Zamknij"><i class="icon fa-solid fa-xmark"></i></button>
        </header>
        <div class="container-small">
          <div class="input-title">Zaszyfrowane hasło</div>
          <div class="custom-input"><input type="text" name="generated-password-hash" value="<?php echo $passwordHash ?>" readonly><button class="copy-btn" title="Kopiuj"><i class="icon fa-regular fa-copy"></i></button></div>
        </div>

        <?php if ($salt !== "") { ?>
          <div class="container-small">
            <div class="input-title">Sól</div>
            <div class="custom-input"><input type="text" name="generated-salt" value="<?php echo $salt ?>" readonly><button class="copy-btn" title="Kopiuj"><i class="icon fa-regular fa-copy"></i></button></div>
          </div>
        <?php } ?>
      </div>
    <?php } ?>
  </body>
</html>
