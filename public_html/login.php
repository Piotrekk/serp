<!DOCTYPE html>

<?php
  include '../../serp_config.php';
  include 'php/utils/connection.php';
?>

<html>
  <head>
    <title>SERP - System Elektronicznej Rejestracji Pacjenta</title>
    <link rel="stylesheet" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>

  <body>

    <?php
      include 'php/components/header.php';
    ?>

    <?php
      include 'php/utils/encryption.php';

      if (!empty($_SESSION["authentication_error"])) {
        unset($_SESSION["authentication_error"]);
      }

      if (!empty($_POST["email"]) && !empty($_POST["password"])) {
        $loginQuery = mysqli_query($server, "SELECT * from Users WHERE email LIKE '".$_POST["email"]."'"."AND password LIKE '".encrypt($_POST["password"])."'")
         or die ("Zle sformulowane query");

        $result = mysqli_fetch_assoc($loginQuery);

        if (is_array($result)) {
          $accessToken = bin2hex(random_bytes(8));
          $insertQuery = "INSERT INTO Logins (user_id, token) VALUES ('".array_values($result)[0]."', '".$accessToken."')";
          mysqli_query($server, $insertQuery);

          setrawcookie("serp_user_email", $_POST['email'], time() + (86400 * 30), "/");
          setrawcookie("serp_user_token", $accessToken, time() + (86400 * 30), "/");
          setrawcookie("serp_user_firstname", array_values($result)[1]);
          setrawcookie("serp_user_lastname", array_values($result)[2]);
          setrawcookie("serp_user_type", array_values($result)[3]);

          echo "<script type='text/javascript'>
                  window.location = '/app/app.php';
                </script>";
        } else {
          $_SESSION["authentication_error"] = true;
        }
      }
    ?>

    <section class="p-login main-background-gradient">
      <div class="h-inner u-margin-top--base">

        <h1 class="u-margin-bottom--base-x2">Zaloguj się</h1>

        <form method="POST">
          <input class="input u-margin-bottom--base" type="email" name="email" placeholder="Email" />
          <input class="input u-margin-bottom--base" type="password" name="password" placeholder="Hasło" />
          <input class="button button--color-blue" type="submit" value="Zaloguj się" />
        </form>

        <?php
          if (!empty($_SESSION["authentication_error"])) {
            echo "<span class='u-display--flex u-justify-content--center u-margin-top--base u-color--red'>Nieprawidłowy email lub hasło!</span>";
          }
        ?>

      </div>
    </section>

  </body>
</html>
