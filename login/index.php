<?php
  $logged = false;
  $exists = false;
  $id = "";

  $looking = false;

  // print_r($_POST);

  if (isset($_POST['email-turdoteca'])) {
    $looking = true;
    $email    = $_POST['email-turdoteca'];
    $password = $_POST['password-turdoteca'];

    $usersMaps = scandir('../db/users/map/');

    foreach ($usersMaps as $map) {
      if (!in_array($map, ['.', '..'])) {
        $users = file_get_contents("../db/users/map/" . $map);
        $users = json_decode($users, true);

        if (!$exists) {
          foreach ($users as $user) {
            if ($user['email'] == $email) {
              $exists = true;
              $id = $user['id'];
            }
          }
        }
      }
    }

    if ($exists) {
      $userData = file_get_contents('../db/users/' . $id . '.json');
      $userData = json_decode($userData, true);

      if ($password == $userData['password']) {
        $logged = true;

        session_start();

        $_SESSION['turdoteca'] = $id;

        session_write_close();

        header('Location: ../');
      }
    }
  }
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../main.css">
  <link rel="stylesheet" href="style.css">
  <title>Crear Cuenta</title>
</head>
<body>
  <header>
    <a href="../">
      <div class="logo">
        <img src="../imgs/turdoteca_logo.svg" alt="TurdoTeca Logo">
      </div>
    </a>
  </header>
  <div class="login">
    <div class="side">
      <?php
        $phrases = file_get_contents('../books/phrases.json');
        $phrases = json_decode($phrases, true);
        echo "<i class='phrase'>";
        $rand = floor(random_int(0, count($phrases) - 1));
        echo $phrases[$rand]['phrase'];
        echo "</i>";
        echo '<p class="author">' . $phrases[$rand]['author'] . '</p>';
      ?>
    </div>
    <form action="../login/" method="post">
      <h2>Iniciar Sesión</h2>
      <input type="email" name="email-turdoteca", id="email-turdoteca" autocomplete="off" placeholder="Correo" required>
      <input type="password" name="password-turdoteca" id="password-turdoteca" autocomplete="off" placeholder="Contraseña" required>
      <input type="submit" value="Entrar">
      <p class="signup">¿No tienes cuenta? <a href="../signup/">Crear Cuenta</a></p>
    </form>
  </div>
  <?php
    if ($looking && !$exists) {
      echo '<div class="error-alert">Usuario o Contraseña Incorrecta</div>';
    }
    
    if ($looking && $exists && !$logged) {
      echo '<div class="error-alert">Usuario o Contraseña Incorrecta</div>';
    }
  ?>
  <footer>
    <div class="made">
      <p>Hecho por</p>
      <div class="made-logo">
        <img src="../imgs/turdo_logo.svg" alt="" srcset="">
      </div>
    </div>
    <div class="donate"></div>
    <div class="legal">
      <p>This web page is for personal and educational use, not created for commercial purposes.</p>
    </div>
  </footer>
</body>
</html>