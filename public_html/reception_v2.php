<?php
  session_start();
  if(isset($_GET['showRoom'])) $_SESSION['newRoom'] = $_GET['showRoom'];
  if(isset($_GET['showTime'])) $_SESSION['newTime'] = $_GET['showTime'];
  if(isset($_GET['showId'])) $_SESSION['newId'] = $_GET['showId'];
  if(isset($_GET['showTime'])) $_SESSION['newTime'] = $_GET['showTime'];
  if(isset($_GET['showPatient'])) $_SESSION['newPatient'] = $_GET['showPatient'];
  if(isset($_GET['showDate'])) $_SESSION['newDate'] = $_GET['showDate'];
  if(isset($_GET['showDFN'])) $_SESSION['newDFN'] = $_GET['showDFN'];
  if(isset($_GET['showDLN'])) $_SESSION['newDLN'] = $_GET['showDLN'];
  if(isset($_GET['showDoctorId'])) $_SESSION['newDoctorId'] = $_GET['showDoctorId'];


  include '../../serp_config.php';
  include 'php/utils/connection.php';
?>

<!DOCTYPE html>

<html>
  <head>
    <title>SERP - System Elektronicznej Rejestracji Pacjenta</title>
    <link rel="stylesheet" href="css/styleKF2.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/time.js"></script>
  </head>

  <body>

    <?php
      include 'php/components/header.php';
    ?>
    <!-- Trigger/Open The Modal -->




<!--lista lekarzy -->
<div class="flex-container">

<!-- <div class="p-waiting-room__visits"> -->
<div class="leftMenu font-size--13 ">
<span class="font-bold font-size--16">Dopasuj:</span>
    <form action="" method="POST">
    <?php
    //if(isset($_GET['showId'])) echo "Jestffffffffffffffffffffffffffffffffffff";

      $queryDoctorList = 'SELECT id,first_name,last_name FROM Users WHERE type = "lekarz"';
      $doctorList = mysqli_query($server, $queryDoctorList) or die ("Zle sformulowane query");

      //$doctorListFull =[];
      $selectedDoctorList = null;
      $showSelected = " ";
      while ($row = mysqli_fetch_array($doctorList))
      {
          $checked = " ";
          if(!empty($_POST["idLekarza"]))
           {
             $selectedDoctorList = $_POST['idLekarza'];
             foreach ($selectedDoctorList as $value)
             {
               if($value == $row[0])
                  {
                    $checked = " checked='checked' ";
                    $showSelected .= " Visits.doctor_id = $row[0] OR";
                  }
             }
           }
          echo "<span class=\"block\">
                <input  type=\"checkbox\" name=\"idLekarza[]\" value=\"$row[0]\" $checked>
                $row[1] $row[2]
                </span>";
        //array_push($doctorListFull, "$row[0]");

      }
      //tu

    ?>
<div class="margin_vertical_10">
  <span class="block"><input type="radio" name="freeDayOnly" value="yes">Tylko wolne terminy</span>
  <span class="block"><input type="radio" name="freeDayOnly" value="no">Wszystkie terminy</span>
</div>

<div class="margin_vertical_10">
  <span class="block">Od:<input type="date" name="startDate" value="1"></span>
  <span class="block">Do:<input type="date" name="endDate" value="1"></span>
</div>
<div class="margin_vertical_10">
  <span class="block">
    <input type="radio" name="free" value="1">od rana
    <input type="radio" name="free" value="1">popołudniu
  </span>
</div>

  <!--  <input type="reset" value="Pokaż Wszystkich"> -->
  <span class="block margin_vertical_10"><input type="submit" name="submit"  value="Pokaż"></span>
  </form>

  </div>
    <div class="Table align_top">
        <div class="Title">
            <p>Harmonogram pracy Przychodni</p>
        </div>

            <?php
// warunki

if($showSelected != " ")
{
  $showSelected = substr($showSelected, 0, -2);
  $showSelected .= " AND ";
}

$freeDayOnly = " ";
if(isset($_POST["freeDayOnly"]))
{
  //  $freeDayOnly = $_POST['freeDayOnly'];
    if($_POST['freeDayOnly'] == "yes")
      $freeDayOnly = " AND Visits.patient_id IS NULL ";
}
//**************SQL Doctor select*****************************
              $queryDoctorList = "SELECT Visits.doctor_id, Users.last_name, Users.first_name
                                  FROM Visits, Users
                                  WHERE $showSelected  Users.id = Visits.doctor_id $freeDayOnly/*AND Visits.date = UTC_DATE() AND Visits.status = wo; */
                                  GROUP BY doctor_id";

              $doctorList = mysqli_query($server, $queryDoctorList) or die ("Zle sformulowane query");

              while ($row = mysqli_fetch_array($doctorList))

              {
                  echo "<div class=\"Row\">";
                  echo "<div class=\"Cell\">$row[1] $row[2]</div>";

//**************SQL VISITS************************************
$queyVisits = "SELECT Visits.room, Visits.id, Visits.time, Visits.patient_id, Visits.date
               FROM Visits
               WHERE Visits.doctor_id = {$row[0]} $freeDayOnly  /* AND Visits.status = za AND Visits.date = UTC_DATE()*/
               ORDER BY Visits.time
               LIMIT 500";

                  $visits = mysqli_query($server, $queyVisits) or die ("Zle sformulowane query");
                  // doctors list
                  while ($visit = mysqli_fetch_array($visits))
                  {
//wizyty dodawanie edycja! ****************************************************************
                      if($visit[3] > 0)
                      {
                        $hour = substr($visit[2],0,5);
                        //echo "<div class=\"Cell cursor-zoom \">
                        echo "<div class=\"Cell cursor-zoom \" onclick=location.href=\"wp.pl\"  >
                                  <span class=\"block\">$visit[0]</span>
                                  <span class=\"block\">$visit[1]</span>
                                  <span class=\"block\">$visit[2]</span>
                              </div>";
                      }
                      else
                      {
                        //echo "<div class=\"Cell red cursor-grab \" onclick=\"showModal()\">
                        echo "<div class=\"Cell red cursor-grab \" onclick=location.href=\"reception_v2.php?showRoom=$visit[0]&showId=$visit[1]&showTime=$visit[2]&showPatient=$visit[3]&showDate=$visit[4]&showDFN=$row[1]&showDLN=$row[2]&showDoctorId=$row[0]\">
                                  <span class=\"block\">$visit[0]</span>
                                  <span class=\"block\">Wolny</span>
                                  <span class=\"block\">$visit[2]</span>
                              </div>";
                      }
                  }
//wizyty dodawanie edycja! **********************KONIEC************************************
                echo "</div>";
              }

              ?>

    </div>

<?php
/*

dodanie wielu wizyt..

for($i=12;$i<19;$i++)
{
$z = "INSERT INTO `Visits` (`id`, `date`, `time`, `status`, `room`, `patient_id`, `doctor_id`)
VALUES (NULL, '2018-12-26', '{$i}:00:00', 'wo', '11', NULL, '1'),
 (NULL, '2018-12-26', '{$i}:15:00', 'wo', '11', NULL, '1'),
(NULL, '2018-12-26', '{$i}:30:00', 'wo', '11', NULL, '1'),
(NULL, '2018-12-26', '{$i}:45:00', 'wo', '11', NULL, '1')";
$zz = mysqli_query($server, $z) or die ("Zle sformulowane query");

}
*/

 ?>
</div>

<?php
if(isset($_GET['showRoom']) and (!isset($_POST['patientFN']) or !isset($_POST['patientLN'])) ) {
?>

<!--********************Wpisz dane nowej wizyty**************************-->
<div id="myModal" class="modal">
  <div class="modal-content">
      <div>
          <span class="close align_right">&times;</span>
      </div>
      <form method="post" name="add">
      <div class="inline">
        <p>Dane Pacienta:<p>
                <div class="">
                    <div class="">Pesel:</div>
                    <div class=""><input type="text" name="patientPesel"></div>
                </div>

        <p>Dane nowego Pacienta:<p>
                <div>
                    <div class="">Imię:</div>
                    <div class=""><input type="text" name="patientFN"></div>
                </div>
                <div class="">
                    <div class="">Nazwiko:</div>
                    <div class=""><input type="text" name="patientLN"></div>
                </div>
                <div class="">
                    <div class="">Pesel:</div>
                    <div class=""><input type="text" name="patientPesel"></div>
                </div>

      </div>
<!--  </div> -->

      <div class="inline">
          <p>Lekarz:<p>
          <?php echo $_GET['showDFN']." ".$_GET['showDLN']; ?>
      </div>
      <div class="inline">
          <p>Szczegóły<p>
          <?php
          echo "Gabinet: ".$_GET['showRoom']."<br>";
          echo "Godzina: ".$_GET['showTime']."<br>";
          echo "Data: ".$_GET['showDate'];
          ?>
      </div>

      <p><input type="submit" value="Dodaj Wizyte"><p>
      </form>
    </div>

  </div>
<!-- </div> -->
<!--***************koniec Wpisz dane nowej wizyty**************************-->
<?php }
else if(isset($_POST['patientFN']) and isset($_POST['patientLN'])) {
//*********************informacja o dodaniu wizyty************
?>

<div id="myModal" class="modal">
    <div class="modal-content">
          <div>
              <span class="close align_right">&times;</span>
          </div>
          <?php
          //****************dodanie wizyty SQL**************************

          $addVisit = "SELECT Patients.pesel FROM `Patients` WHERE Patients.pesel = "


          $addVisit = "INSERT INTO `Visits` (`id`, `date`, `time`, `status`, `room`, `patient_id`, `doctor_id`)
                VALUES (NULL, '{$_SESSION['newId']}', '{$_SESSION['newTime']}', 'za', '{$_SESSION['newRoom']}', '{$_SESSION['newPatientId']}', '{$_SESSION['newDoctorId']}')";
          $addVisitTest = mysqli_query($server, $z) or die ("Zle sformulowane query");
          if($addVisitTest !== false)
            echo "Wizyta została zarejestrowana w systemie.";
          else
            echo "Coś poszło nie tak..";

          //******** koniec dodanie wizyty SQL**************************
          ?>
    </div>
</div>

<?php
 }
//*****************koniec informacja o dodaniu wizyty*********
?>

<script>
var modal = document.getElementById('myModal');
var span = document.getElementsByClassName("close")[0];

span.onclick = function() {
  modal.style.display = "none";
  location.href="reception_v2.php";

}

</script>

  </body>
</html>
