<!DOCTYPE html>

<?php
  include 'php/utils/connection.php';
?>

<html>
  <head>
    <title>SERP - System Elektronicznej Rejestracji Pacjenta</title>
    <link rel="stylesheet" href="css/style.css">
  </head>

  <body>

    <?php
      $users_query = mysqli_query($server, "SELECT * from Users") or die ("Zle sformulowane query");

      while ($row = mysqli_fetch_array($users_query)) {
        echo implode(' ', $row);
      }
    ?>

  </body>
</html>
