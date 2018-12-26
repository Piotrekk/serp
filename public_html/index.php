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

    if (mysqli_connect_errno())
      {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
      }


  //  global $server;
      $query1 =    'SELECT * FROM `Patients`';
      $users_query = mysqli_query($server, $query1) or die ("Zle sformulowane query");

      while ($row = mysqli_fetch_array($users_query))
       {
        echo implode(' ', $row);
        }

?>







  </body>
</html>
