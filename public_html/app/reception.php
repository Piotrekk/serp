<?php
  session_start();

  if (isset($_GET['showRoom'])) $_SESSION['lastOpenRoom'] = $_GET['showRoom'];
  if (isset($_GET['showTime'])) $_SESSION['lastOpenTime'] = $_GET['showTime'];
  if (isset($_GET['showId'])) $_SESSION['lastOpenId'] = $_GET['showId'];
  if (isset($_GET['showPatient'])) $_SESSION['lastOpenPatient'] = $_GET['showPatient'];
  if (isset($_GET['showDate'])) $_SESSION['lastOpenDate'] = $_GET['showDate'];
  if (isset($_GET['showDFN'])) $_SESSION['lastOpenDFN'] = $_GET['showDFN'];
  if (isset($_GET['showDLN'])) $_SESSION['lastOpenDLN'] = $_GET['showDLN'];
  if (isset($_GET['showPFN'])) $_SESSION['lastOpenPFN'] = $_GET['showPFN'];
  if (isset($_GET['showPLN'])) $_SESSION['lastOpenPLN'] = $_GET['showPLN'];
  if (isset($_GET['showDoctorId'])) $_SESSION['lastOpenDoctorId'] = $_GET['showDoctorId'];
  if (isset($_POST['newPatientFN'])) $_SESSION['newPatientFN'] = $_POST['newPatientFN'];
  if (isset($_POST['newPatientLN'])) $_SESSION['newPatientLN'] = $_POST['newPatientLN'];
  if (isset($_POST['newPatientPesel'])) $_SESSION['newPatientPesel'] = $_POST['newPatientPesel'];

  function saveInFile($where, $what) {
    $file = fopen($where, "a+");

    while(true) {
        if(flock($file,LOCK_EX)) {
          fputs($file,$what);
          flock($file,LOCK_UN);
          break;
        }
    }

    fclose($file);
  }

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

    <!--lista lekarzy -->
    <div class="p-reception main-background-gradient flex-container">
      <div class="h-inner u-padding-top--base-x4 u-padding-bottom--base-x5">

        <h1 class="main-heading-h1">Recepcja</h1>

        <div class="p-reception__wrapper">

          <div class="p-reception__menu">
            <h2 class="p-reception__header">Dopasuj:</h2>

            <form action="" method="POST">
              <?php
                $queryDoctorList = 'SELECT id,first_name,last_name FROM Users WHERE type = "lekarz"';
                $doctorList = mysqli_query($server, $queryDoctorList) or die ("Zle sformulowane query");

                //$doctorListFull =[];
                $selectedDoctorList = null;
                $showSelected = " ";

                while ($row = mysqli_fetch_array($doctorList)) {
                  $checked = " ";

                  if (!empty($_POST["idLekarza"])) {
                    $selectedDoctorList = $_POST['idLekarza'];

                    foreach ($selectedDoctorList as $value) {
                      if ($value == $row[0]) {
                        $checked = " checked='checked' ";
                        $showSelected .= " Visits.doctor_id = $row[0] OR";
                      }
                    }
                  }

                  echo "<label class='ui-checkbox'>
                          <input type='checkbox' name='idLekarza[]' id='idLekarza-$row[1]' value='$row[0]' $checked>
                          <span>";
                            include '../php/components/svg/svg_ok.php';
                  echo   "</span>
                          <label for='idLekarza-$row[1]'>$row[1] $row[2]</label>
                        </label>";
                }
              ?>

              <div class="u-margin-top--base-half u-padding-top--base-half main-divider-top">
                <label class="ui-radio">
                  <input type="radio" name="freeDayOnly" id="freeDayOnly" value="yes"
                    <?php
                    if (isset($_POST["freeDayOnly"])) {
                      if ($_POST['freeDayOnly'] == "yes") {
                        echo "checked";
                      } else {
                        echo "";
                      }
                    }
                    ?>
                  >
                  <span><?php include '../php/components/svg/svg_ok.php'; ?></span>
                  <label for="freeDayOnly">Tylko wolne terminy</label>
                </label>

                <label class="ui-radio">
                  <input type="radio" name="freeDayOnly" id="allDays" value="no"
                    <?php
                      if (isset($_POST["freeDayOnly"])) {
                        if ($_POST['freeDayOnly'] == "no") {
                          echo "checked";
                        } else {
                          echo "";
                        }
                      } else {
                        echo "checked";
                      }
                    ?>
                  >
                  <span><?php include '../php/components/svg/svg_ok.php'; ?></span>
                  <label for="allDays">Wszystkie terminy</label>
                </label>
              </div>

              <div class="u-margin-top--base-half u-padding-top--base-half main-divider-top">
                <label>
                  Od:
                  <input type="date" name="fromDate" value='<?php if (isset($_POST['fromDate'])) echo ($_POST['fromDate']); else echo date("Y-m-d"/* jutro,strtotime('tomorrow') */) ;  ?>'   class="input input--small">
                </label>

                <label>
                  Do:
                  <input type="date" name="toDate" value='<?php if (isset($_POST['toDate'])) echo ($_POST['toDate']); ?>'  class="input input--small">
                </label>
              </div>

              <div class="u-margin-top--base-half u-padding-top--base-half main-divider-top">
                <label class="ui-radio">
                  <input type="radio" name="fromTime" value="06:00:00" <?php if (isset($_POST["fromTime"])) if ($_POST['fromTime'] == '06:00:00') echo "checked"; ?>  id="fromMorning">
                  <span><?php include '../php/components/svg/svg_ok.php'; ?></span>
                  <label for="fromMorning">Rana</label>
                </label>

                <label class="ui-radio">
                  <input type="radio" name="fromTime" value="12:00:00" <?php if (isset($_POST["fromTime"])) if ($_POST['fromTime'] == '12:00:00') echo "checked"; ?>  id="fromAfternoon">
                  <span><?php include '../php/components/svg/svg_ok.php'; ?></span>
                  <label for="fromAfternoon">Popołudniu</label>
                </label>
              </div>

              <input type="submit" name="submit"  value="Pokaż" class="button button--color-blue button--small u-margin-top--base">
            </form>
          </div>

          <div class="c-timetable">
            <h2 class="c-timetable__header">Harmonogram pracy Przychodni</h2>

            <?php
              // warunki
              if ($showSelected != " ") {
                $showSelected = substr($showSelected, 0, -2);
                $showSelected .= " AND ";
              }

              $freeDayOnly = " ";
              if (isset($_POST["freeDayOnly"])) {
                if ($_POST['freeDayOnly'] == "yes") {
                  $freeDayOnly = " AND Visits.patient_id IS NULL ";
                }
              }

              $fromTime = " ";
              if (isset($_POST['fromTime'])) {
                if ($_POST['fromTime'] == '06:00:00') {
                  $fromTime = " AND Visits.time >= '".$_POST['fromTime']."' AND Visits.time < '12:00:00' ";
                } else {
                  $fromTime = " AND Visits.time >= '".$_POST['fromTime']."'";
                }
              }

              $fromData = " ";
              if (isset($_POST["fromDate"])) {
                $fromData = " AND Visits.date >= '".($_POST["fromDate"])."' ";
              }

              $toData = " ";
              if (isset($_POST["toData"])) {
                $toData = " AND Visits.date <= '".($_POST["toData"])."' ";
              }

              //**************SQL Doctor select***********************************************************************
              $queryDoctorList = "SELECT Visits.doctor_id, Users.last_name, Users.first_name
                                  FROM Visits, Users
                                  WHERE $showSelected  Users.id = Visits.doctor_id $freeDayOnly/*AND Visits.date = UTC_DATE() AND Visits.status = wo; */
                                  GROUP BY doctor_id";

              $doctorList = mysqli_query($server, $queryDoctorList) or die ("Zle sformulowane query");

              while ($row = mysqli_fetch_array($doctorList)) {
                echo "<div class='c-timetable__row'>";
                echo "<div class='c-timetable__doctor'>$row[1] $row[2]</div>";
                echo "<div class='c-timetable__cell-wrapper'>";

                //**************SQL VISITS****************************************************************************
                $queyVisits = "SELECT Visits.room, Visits.id, Visits.time, Visits.patient_id, Visits.date, Patients.first_name, Patients.last_name
                               FROM Visits
                               LEFT JOIN Patients ON Visits.patient_id = Patients.id
                               WHERE Visits.doctor_id = {$row[0]} $freeDayOnly $fromData $toData $fromTime   /* AND Visits.status = za AND Visits.date = UTC_DATE()*/
                               ORDER BY Visits.time
                               LIMIT 500";

                $visits = mysqli_query($server, $queyVisits) or die ("Zle sformulowane query");

                // doctors list
                while ($visit = mysqli_fetch_array($visits)) {
                  //wizyty podglad ************************************************************************************
                  if ($visit[3] > 0) {
                    $hour = substr($visit[2],0,5);
                    $visitId = strtoupper(dechex($visit[1]));
                    echo "<div class='c-timetable__cell u-cursor--zoom-in' onclick=location.href='reception.php?showRoom=$visit[0]&showId=$visit[1]&showTime=$visit[2]&showPatient=$visit[3]&showDate=$visit[4]&showDFN=$row[1]&showDLN=$row[2]&showDoctorId=$row[0]&showPFN=$visit[6]&showPLN=$visit[5]'>
                            <span>$visit[0]</span>
                            <span>$visitId</span>
                            <span>$visit[2]</span>
                          </div>";
                  } else {
                    // Wysylanie dodawanie*****************************************************************************
                    echo "<div class='c-timetable__cell c-timetable__cell--free u-cursor--grab' onclick=location.href='reception.php?showRoom=$visit[0]&showId=$visit[1]&showTime=$visit[2]&showPatient=$visit[3]&showDate=$visit[4]&showDFN=$row[1]&showDLN=$row[2]&showDoctorId=$row[0]&showPFN=$visit[6]&showPLN=$visit[5]'>
                            <span>$visit[0]</span>
                            <span>Wolny</span>
                            <span>$visit[2]</span>
                          </div>";
                  }
                }

                //wizyty dodawanie edycja! **********************KONIEC************************************************
                echo "</div>";
                echo "</div>";
              }
            ?>
          </div>
        </div>
      </div>
    </div>

    <?php
      if (isset($_GET['showRoom'])) {
    ?>
      <!--***************Dodaj nowa lub Wyświetl dane istniejacej wizyty*********************************************-->
      <div id="myModal" class="c-modal">
        <div class="c-modal__wrapper">
          <div class="c-modal__header">
            <p>
              <?php
                if ($_GET['showPatient']) { // mamy Pacjenta
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
            <!--***************Dodawanie pacjenta do wizyty*******************************************-->
            <?php
            if (!$_GET['showPatient']) { // nie mamy pacjenta ******************************************
            ?>
              <h3 class="u-margin-bottom--base">Dane Pacjenta:</h3>

              <label>
                <span>Pacjent:</span>
                <?php //SELECT ************************************************************************SELECT*******
                  echo  "<select name=\"fomSelectPatient\" class=\"input input--small\">";
                  echo  "<option value=\"\" selected disabled hidden >Znajdz Pacjenta</option>";

                  $queryPatientList = "SELECT first_name, last_name, pesel, id FROM Patients ORDER BY first_name ASC";
                  $resultPatientList = mysqli_query($server, $queryPatientList);

                  while($rowPatientList=mysqli_fetch_array($resultPatientList)) {
                    echo "<option value='".$rowPatientList[3]."' >".$rowPatientList[0]." ".$rowPatientList[1]."  PESEL: ".$rowPatientList[2]."</option>";
                  }
                  echo  "</select>";
                ?>
              </label>

              <h3 class="u-margin-top--base">Dane nowego Pacienta:</h3>

              <label>
                <span>Imię:</span>
                <input type="text" name="newPatientFN" class="input input--small">
              </label>

              <label>
                <span>Nazwisko:</span>
                <input type="text" name="newPatientLN" class="input input--small">
              </label>

              <label>
                <span>Pesel:</span>
                <input type="text" name="newPatientPesel" class="input input--small">
              </label>

            <?php
              } else {
            ?>
              <!--*************** Wyswietl dane wskazanej wizyty **************************-->
              <h3 class="u-margin-bottom--base">Dane Pacjenta:</h3>

              <label>
                <span>Imię:</span>
                <?php
                  echo $_GET['showPFN'];
                ?>
              </label>

              <label>
                <span>Nazwisko:</span>
                <?php
                  echo $_GET['showPLN'];
                ?>
              </label>
            <?php
              }
            ?>

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
                  echo "<button class='button button--color-blue' type='button' onclick=location.href='reception.php?usun=".$_GET['showId']."'>Zwolnij Wizyte</button> ";
                } else {
                  echo "<input type='submit' value='Dodaj Wizyte' class='button button--color-blue'>";
                }
              ?>
            </form>
          </div>
        </div>
      </div>
      <!--***************koniec Dodaj nowa lub Wyświetl dane istniejacej wizyty**************************-->

    <?php
      }

      if(( isset($_POST['newPatientFN']) and isset($_POST['newPatientLN']) ) or isset($_POST['fomSelectPatient']) ) {
      //*********************informacja o dodaniu wizyty i dodanie w SQL***********************************************8
    ?>

      <div id="myModal" class="c-modal">
        <div class="c-modal__wrapper">
          <div class="c-modal__header">
            <p>Nowa wizyta</p>
            <?php
            // zmiana na zamykanie po okreslonym czasie.
            // include '../php/components/svg/svg_cancel.php'
            ?>
          </div>

          <div class="c-modal__content">
            <?php
              $idPatientUpdate = null;
              if (!isset($_POST['fomSelectPatient'])) { // SQL dodaje dodaje nowego pacjenta i wyszukuje jego ID po nr PESEL
                  //*********************************************Walidacja PESEL************************************
                  $validation = "SELECT COUNT(pesel) FROM Patients WHERE pesel = {$_SESSION['newPatientPesel']}";
                  $validationTest = mysqli_query($server, $validation);
                  $validationTable = mysqli_fetch_array($validationTest);

                  if ($validationTable[0] < 1) {
                      $addPatient = "INSERT INTO `Patients` (`id`, `first_name`, `last_name`, `pesel`)
                                    VALUES (NULL, '{$_SESSION['newPatientLN']}', '{$_SESSION['newPatientFN']}', {$_SESSION['newPatientPesel']})";
                      mysqli_query($server, $addPatient) or die ("Zle sformulowane dodania pacjenta..");
                      //*********************Zapis nowgo pacjenta do pliku txt***************************************
                      // pliki txt z pacjentami i wizytami zawieraja polecenia SQL - pozwola odtworzyc baze w sql.
                      saveInFile("addPatient.dat",$addPatient."\r\n");

                      $findIdPatient = "SELECT id from Patients WHERE Patients.pesel = '{$_SESSION['newPatientPesel']}' ";
                      $resultFindIdPatient = mysqli_query($server, $findIdPatient) or die ("Zle sformulowane dodania pacjenta..");
                      $tableFindIdPatient = mysqli_fetch_array($resultFindIdPatient);
                      $idPatientUpdate = $tableFindIdPatient[0];
                  } else {
                    $idPatientUpdate = -1;
                  }
                } else {
                  $idPatientUpdate = $_POST['fomSelectPatient'];
                }

                if ($idPatientUpdate != -1) {
                  $addVisit = "UPDATE `Visits` SET `status`='za', `patient_id`='{$idPatientUpdate}'
                              WHERE Visits.id = '{$_GET['showId']}' ";
                  //*********************Zapis nowej wizyty do pliku txt***************************************
                  saveInFile("Visits.dat",$addVisit."\r\n");

                  $addVisitTest = mysqli_query($server, $addVisit) or die ("Zle sformulowane query");
                  if ($addVisitTest !== false) {
                    echo "Wizyta została zarejestrowana w systemie.";
                  } else {
                    echo "Coś poszło nie tak..";
                  }
                }
                else {
                  echo "PESEL istnieje już w bazie";
                }
            ?>
          </div>
        </div>
      </div>

      <!-- po uplywie czasu 3sekund powraca do okna glownego -->
      <script type="text/javascript">
        setTimeout("location.href='reception.php';",3000);
      </script>

    <?php
      //******** koniec dodanie wizyty i SQL**************************
      } else if (isset($_GET['usun'])) {
      //*********************informacja o zwolnieniu wizyty - usuwa pacjena z wizyty w SQL************
    ?>

      <div id="myModal" class="c-modal">
        <div class="c-modal__wrapper">
          <div class="c-modal__header">
            <p>Potwierdzenie</p>
            <?php include '../php/components/svg/svg_cancel.php' ?>
          </div>

          <div class="c-modal__content">
            <?php
              $SetPatientNULL  = "UPDATE `Visits` SET `status` = 'wo', `patient_id` = NULL WHERE `Visits`.`id` = '{$_GET['usun']}'";
              $TestSetPatientNULL =  mysqli_query($server, $SetPatientNULL) or die ("Zle sformulowane zwolnienie wizyty..");

              if ($TestSetPatientNULL !== false) {
                echo "Wizyta została zwolniona";
                saveInFile("Visits.dat", $SetPatientNULL."\r\n");
              } else {
                echo "Coś poszło nie tak ze zwolnieniem wizyty..";
              }
            ?>
          </div>
        </div>
      </div>
    <?php //******** koniec zwalniania wizyty i SQL**************************
      }
    ?>

    <script>
      window.onload = function() {
        closeModal('reception.php');
      }
    </script>

<?php
/*
$iroom = "17";
$idoc = "3";

for($i=9;$i<13;$i++)
{
$z = "INSERT INTO `Visits` (`id`, `date`, `time`, `status`, `room`, `patient_id`, `doctor_id`)
VALUES (NULL, '2018-12-26', '{$i}:00:00', 'wo', '{$iroom}', NULL, '{$idoc}'),
 (NULL, '2018-12-26', '{$i}:15:00', 'wo', '{$iroom}', NULL, '{$idoc}'),
(NULL, '2018-12-26', '{$i}:30:00', 'wo', '{$iroom}', NULL, '{$idoc}'),
(NULL, '2018-12-26', '{$i}:45:00', 'wo', '{$iroom}', NULL, '{$idoc}')";
$zz = mysqli_query($server, $z) or die ("Zle sformulowane query");

}
*/

?>


  </body>
</html>
