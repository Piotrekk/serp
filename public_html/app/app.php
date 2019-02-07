<!DOCTYPE html>

<?php
  include '../../../serp_config.php';
  include '../php/utils/connection.php';
  include '../php/utils/authentication.php';
?>

<html>
  <head>
    <title>SERP - System Elektronicznej Rejestracji Pacjenta</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/time.js"></script>
  </head>

  <body>

    <?php
      include '../php/components/header.php';
    ?>

    <section class="p-app main-background-gradient">
      <div class="h-inner u-padding-top--base-x4">

        <h1 class="main-heading-h1">Witaj, <?php echo $_COOKIE['serp_user_firstname']; ?></h1>

        <div class="p-app__wrapper">

          <div class="p-app__box">
            <h1>
              <script type="text/javascript">
                time()
              </script>
            </h1>
          </div>

          <div class="p-app__box">
            <h1>
              <?php
                $visitsCountQuery = mysqli_query($server, "SELECT Count(*) FROM Visits WHERE date = '".date("Y-m-d")."'") or die ("Zle sformulowane query");
                echo mysqli_fetch_array($visitsCountQuery)[0];
              ?>
            </h1>

            <h2>pozostałych pacjentów dzisiaj</h2>
          </div>

        </div>

      </div>
    </section>

  </body>
</html>
