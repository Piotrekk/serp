<!DOCTYPE html>

<?php
  include '../../serp_config.php';
  include 'php/utils/connection.php';
?>

<html>
  <head>
    <title>SERP - System Elektronicznej Rejestracji Pacjenta</title>
    <link rel="stylesheet" href="css/style.css">
  </head>

  <body>

    <?php
      include 'php/components/header.php';
    ?>

    Logowanie

    <?php
      function randHash($length = 32) {
        return substr(md5(openssl_random_pseudo_bytes(20)), -$length);
      }

      if (!empty($_POST["email"]) && !empty($_POST["password"])) {
        $loginQuery = mysqli_query($server, "SELECT * from Users WHERE email LIKE '".$_POST["email"]."'"."AND password LIKE '".$_POST["password"]."'")
         or die ("Zle sformulowane query");

        $result = mysqli_fetch_assoc($loginQuery);

        if (is_array($result)) {
          $accessToken = randHash(20);
          $insertQuery = "INSERT INTO Logins (user_id, token) VALUES ('".array_values($result)[0]."', '".$accessToken."')";
          mysqli_query($server, $insertQuery);

          setrawcookie("serp_user_email", $_POST['email'], time() + (86400 * 30), "/");
          setrawcookie("serp_user_token", $accessToken, time() + (86400 * 30), "/");

          echo "<script type='text/javascript'>
                  window.location = '/app/app.php';
                </script>";
        } else {
          echo "Nieprawidłowy email lub hasło!";
        }
      }
    ?>

    <section>
      <div class="h-inner u-margin-top--base">

        <form method="POST">
          <input type="email" name="email" />
          <input type="password" name="password" />
          <input type="submit" value="Zaloguj się" />
        </form>

      </div>
    </section>

  </body>
</html>