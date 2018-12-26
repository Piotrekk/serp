<!DOCTYPE html>

<html>
  <head>
    <title>SERP - System Elektronicznej Rejestracji Pacjenta</title>
    <link rel="stylesheet" href="css/style.css">
  </head>

  <body>

    <?php

      include 'php/components/header.php';

      if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
      }

    ?>

    SERP strona glowna

  </body>
</html>
