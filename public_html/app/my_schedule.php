<?php
  session_start();

  if (isset($_GET['showRoom'])) $_SESSION['newRoom'] = $_GET['showRoom'];
  if (isset($_GET['showTime'])) $_SESSION['newTime'] = $_GET['showTime'];
  if (isset($_GET['showId'])) $_SESSION['newId'] = $_GET['showId'];
  if (isset($_GET['showTime'])) $_SESSION['newTime'] = $_GET['showTime'];
  if (isset($_GET['showPatient'])) $_SESSION['newPatient'] = $_GET['showPatient'];
  if (isset($_GET['showDate'])) $_SESSION['newDate'] = $_GET['showDate'];
  if (isset($_GET['showDFN'])) $_SESSION['newDFN'] = $_GET['showDFN'];
  if (isset($_GET['showDLN'])) $_SESSION['newDLN'] = $_GET['showDLN'];
  if (isset($_GET['showDoctorId'])) $_SESSION['newDoctorId'] = $_GET['showDoctorId'];
  if (isset($_POST['newPatientFN'])) $_SESSION['newPatientFN'] = $_POST['newPatientFN'];
  if (isset($_POST['newPatientLN'])) $_SESSION['newPatientLN'] = $_POST['newPatientLN'];
  if (isset($_POST['newPatientPesel'])) $_SESSION['newPatientPesel'] = $_POST['newPatientPesel'];


  include '../../../serp_config.php';
  include '../php/utils/connection.php';
  include '../php/utils/authentication.php';
?>

<!DOCTYPE html>

<html>
  <head>
    <title>SERP - System Elektronicznej Rejestracji Pacjenta</title>
    <link rel="stylesheet" href="../css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../js/modal.js"></script>
  </head>

  <body>

    <?php
      include '../php/components/header.php';
    ?>

    <div class="p-reception main-background-gradient flex-container">
      <div class="h-inner u-padding-top--base-x4">

        <h1 class="main-heading-h1">Mój plan</h1>

        <div class="c-timetable">
          <div class="c-timetable__row">
            <div class="c-timetable__cell-wrapper">
              <?php
                $queyVisits = "SELECT Visits.room, Visits.id, Visits.time, Visits.patient_id, Visits.date
                               FROM Visits
                               WHERE Visits.doctor_id = 1
                               ORDER BY Visits.time
                               LIMIT 500";

                $visits = mysqli_query($server, $queyVisits) or die ("Zle sformulowane query");

                while ($visit = mysqli_fetch_array($visits)) {
                  if ($visit[3] > 0) {
                    $hour = substr($visit[2],0,5);
                    echo "<div class='c-timetable__cell u-cursor--zoom-in' onclick=location.href='my_schedule.php?showRoom=$visit[0]&showId=$visit[1]&showTime=$visit[2]&showPatient=$visit[3]&showDate=$visit[4]&showDFN=Agnieszka&showDLN=Kowalska&showDoctorId=1'>
                            <span>$visit[0]</span>
                            <span>$visit[1]</span>
                            <span>$visit[2]</span>
                          </div>";
                  } else {
                    echo "<div class='c-timetable__cell c-timetable__cell--free'>
                            <span>$visit[0]</span>
                            <span>Wolny</span>
                            <span>$visit[2]</span>
                          </div>";
                  }
                }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php
      if (isset($_GET['showRoom'])) {
    ?>
      <!--***************Dodaj nowa lub Wyświetl dane istniejacej wizyty**************************-->
      <div id="myModal" class="c-modal">
        <div class="c-modal__wrapper">
          <div class="c-modal__header">
            <p>
              <?php
                if ($_GET['showPatient']) {
                  echo "Szczegoly wizyty";
                } else {
                  echo "Nowa wizyta" ;
                }
              ?>
            </p>
            <?php include '../php/components/svg/svg_cancel.php' ?>
          </div>

          <div class="c-modal__content">
            <form method="post" name="add" class="c-modal__content__form">

              <h3 class="u-margin-bottom--base">Dane Pacjenta:</h3>

              <label>
                <span>Imię:</span>
                <?php
                  echo $_GET['showDFN'];
                ?>
              </label>

              <label>
                <span>Nazwisko:</span>
                <?php
                  echo $_GET['showDLN'];
                ?>
              </label>

              <div class="u-margin-top--base u-padding-top--base main-divider-top">
                <h3 class="u-margin-bottom--base">Lekarz:</h3>
                <?php echo $_GET['showDFN']." ".$_GET['showDLN']; ?>
              </div>

              <div class="u-margin-top--base u-margin-bottom--base u-padding-top--base main-divider-top">
                <h3 class="u-margin-bottom--base">Szczegoly:</h3>
                <?php
                  echo "<label>
                          <span>Gabinet:</span>"
                          .$_GET['showRoom'].
                        "</label>";

                  echo "<label>
                          <span>Godzina:</span>"
                          .$_GET['showTime'].
                        "</label>";

                  echo "<label>
                          <span>Data:</span>"
                          .$_GET['showDate'].
                        "</label>";
                ?>
              </div>

              <?php
                if ($_GET['showPatient']) {
                  echo "<button class='button button--color-blue' type='button' onclick=location.href='my_schedule.php?usun=".$_GET['showId']."'>Oznacz jako zakończona</button> ";
                } else {
                  echo "<input type='submit' value='Dodaj Wizyte' class='button button--color-blue'>";
                }
              ?>
            </form>
          </div>
        </div>
      </div>
    <?php
      }
    ?>

    <?php
      if (isset($_GET['usun'])) {
    ?>
      <div id="myModal" class="c-modal">
        <div class="c-modal__wrapper">
          <div class="c-modal__header">
            <p>Potwierdzenie</p>
            <?php include '../php/components/svg/svg_cancel.php' ?>
          </div>

          <div class="c-modal__content">
            <?php
              $deleteVisit = mysqli_query($server, "DELETE FROM Visits WHERE id = '{$_GET['usun']}'") or die ("Zle sformulowane query");

              if ($deleteVisit !== false) {
                echo "Wizyta została zakończona";
              } else {
                "Coś poszło nie tak ze zwolnieniem wizyty..";
              }
            ?>
          </div>
        </div>
      </div>
    <?php
      }
    ?>

    <script>
      window.onload = function() {
        closeModal('my_schedule.php');
      }
    </script>

  </body>
</html>
