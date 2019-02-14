<?php
  session_start();
  //potrzebne do $_SESSION['idP']
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

    <?php
    $queryCount = "SELECT COUNT(*) FROM `Patients` ";

    $resultCount = mysqli_query($server, $queryCount) or die ("Zle sformulowane query");
    $rowCount = mysqli_fetch_array($resultCount);
    $count = $rowCount[0];
    ?>



            <div class="patient-page">
              <h1 class="main-heading-h1">Lista Pacjentów</h1>
              <div class="search">
                  <form action="" method="GET">
                  <span>Wpisz Pesel:</span>
                  <input type="text" name="pesel">
                  <input type="submit" value="Pokaż">
                  <?php echo "<span>Liczba Pacjentów: ".$count."</span>"; ?>
                  </form>
              </div> <!-- end search side -->
              <div class="show-patienst-list">

                  <?php
                  if(isset($_GET['pesel']))
                    $queryPesel = "WHERE Patients.pesel = ".$_GET['pesel'];

                  $queryPatientsList = "SELECT last_name, first_name, pesel, id
                  FROM `Patients`
                  ORDER by first_name ASC";

                  $PatientsList = mysqli_query($server, $queryPatientsList) or die ("Zle sformulowane query");
                  $i = 0;
                  //zmienna leter to pierwsza litera nazwiska
                  //zmienna ta bedzie dynamicznie zmieniac sie od stanu listy pacjentów
                  while ($row = mysqli_fetch_array($PatientsList))
                  {
                    if($i == 0)
                    {
                      $letter = $row[1]{0};
                      echo "<details><summary class=\"letter\">".$letter."</summary>";
                    }
                    else
                    {
                        if($letter != $row[1]{0})
                        {
                          echo "</details>";
                          $letter = $row[1]{0};
                          echo "<hr>";
                          echo "<details><summary class=\"letter\" >".$letter."</summary>";
                        }
                    }
                      echo "<div class='u-cursor--zoom-in' onclick=location.href='patient_list.php?pesel=".$row[2]."'>";
                      echo "<div class=\"patients-list\">".$row[1]." ".$row[0]."</div>";
                      echo "<div class=\"patients-list\">".$row[2]."</div>";
                    echo "</div>";
                    $i++;
                  }
                  ?>
              </div> <!-- end show-patienst-list side -->
            </div> <!-- patient-page -->

<!-- show Patient *********************************************************************** -->
<?php
  if (isset($_GET['pesel'])) {

    $queryPatient = "SELECT * FROM `Patients` $queryPesel";

    $Patient = mysqli_query($server, $queryPatient) or die ("Zle sformulowane query");
    $rowPatient = mysqli_fetch_array($Patient);
    $_SESSION['idP'] =  $rowPatient[0];
?>
  <div id="myModal" class="c-modal">
    <div class="c-modal__wrapper">
      <div class="c-modal__header">
        <p>Edytuj:</p>
        <?php include '../php/components/svg/svg_cancel.php' ?>
      </div>

      <div class="c-modal__content">
        <form method="post"  class="c-modal__content__form">
          <label>
            <span>Imię:</span>
            <?php
            echo "<input type=\"txt\" name=\"first_name\" value=\"".$rowPatient[2]."\">";
            ?>
          </label>

          <label>
            <span>Nazwisko:</span>
            <?php
            echo "<input type=\"txt\" name=\"last_name\" value=\"".$rowPatient[1]."\">";
            ?>
          </label>

          <div class="u-margin-top--base u-padding-top--base main-divider-top">
            <h3 class="u-margin-bottom--base">Pesel:</h3>
            <?php
            echo "<input type=\"txt\" name=\"pesel\" value=\"".$rowPatient[3]."\">";
            ?>
          </div>

          <div class="u-margin-top--base u-margin-bottom--base u-padding-top--base main-divider-top">
            <?php

              echo "<label>
                      <span>Kraj:</span>
                      <input type=\"txt\" name=\"country\" value=\"".$rowPatient[4]."\">
                    </label>";

              echo "<label>
                      <span>Miasto:</span>
                      <input type=\"txt\" name=\"city\" value=\"".$rowPatient[5]."\">
                    </label>";

              echo "<label>
                      <span>Kod:</span>
                      <input type=\"txt\" name=\"code\" value=\"".$rowPatient[6]."\">
                    </label>";

              echo "<label>
                      <span>Wojew.:</span>
                      <input type=\"txt\" name=\"province\" value=\"".$rowPatient[7]."\">
                    </label>";

              echo "<label>
                      <span>Ulica:</span>
                      <input type=\"txt\" name=\"street\" value=\"".$rowPatient[8]."\">
                    </label>";

              echo "<label>
                      <span>Nr:</span>
                      <input type=\"txt\" name=\"number\" value=\"".$rowPatient[9]."\">
                    </label>";

              echo "<label>
                      <span>Telefon:</span>
                      <input type=\"txt\" name=\"phone\" value=\"".$rowPatient[10]."\">
                    </label>";

            ?>
            <input type='submit' value='Zmien dane' class='button button--color-blue'>
          </div>

        </form>
      </div>
    </div>
  </div>
<?php
  }
?>

<?php
//********************************Zmiana danych***********************
if(isset($_POST['first_name']))
{
  $editPatientQuery = "UPDATE Patients SET Patients.last_name='{$_POST['first_name']}',
                      Patients.first_name='{$_POST['last_name']}', Patients.pesel = '{$_POST['pesel']}',
                      Patients.country='{$_POST['country']}', Patients.city='{$_POST['city']}',
                      Patients.code='{$_POST['code']}', Patients.province='{$_POST['province']}',
                      Patients.street='{$_POST['street']}', Patients.number='{$_POST['number']}',
                      Patients.phone='{$_POST['phone']}'
                      WHERE id = '{$_SESSION['idP']}' ";

echo $editPatientQuery;

  $editPatient = mysqli_query($server, $editPatientQuery) or die ("Zle sformulowane query");
}
?>

  </body>
  </html>
