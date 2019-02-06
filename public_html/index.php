<!DOCTYPE html>

<html>
  <head>
    <title>SERP - System Elektronicznej Rejestracji Pacjenta</title>
    <link rel="stylesheet" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>

  <body>

    <?php

      include 'php/components/header.php';

      if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
      }

    ?>

    <section class="p-homepage main-background-gradient">
      <div class="h-inner">
        <h1 class="main-heading-h1">System Elektronicznej Rejestracji Pacjenta</h1>
        <button class="button button--color-blue">Zarejestruj się</button>
      </div>
    </section>

  </body>
</html>
