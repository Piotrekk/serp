<?php
  include 'php/utils/connection.php';
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
      <meta http-equiv="refresh" content="30">
    <link rel="stylesheet" href="css/styleKF.css">
    <meta charset="utf-8">
    <title></title>

  <?php
  include 'js/time.js';
   ?>

  </head>
  <body>

      <div class="divTopRight">
      <SCRIPT LANGUAGE= "JavaScript" type= "text/javascript">
      time()
      </SCRIPT>
      </div>

  <div class="divTable tableMain">
    <div class ="divTableRow">

<?php

$queryDoctorList = 'SELECT Visits.doctor_id, Users.last_name, Users.first_name
                    FROM Visits, Users
                    WHERE Users.id = Visits.doctor_id AND Visits.date = UTC_DATE()
                    GROUP BY doctor_id';

$doctorList = mysqli_query($server, $queryDoctorList) or die ("Zle sformulowane query");

//lekarze
while ($row = mysqli_fetch_array($doctorList))
{
    echo "<div class =\"divTableRow\">";
    echo "<div class=\"divTableCell lekarze \">dr $row[1] $row[2]</div>";

    echo "<div class=\"divTableCell wizyty\">Gabitent:<br/>Numer:<br/>Godzina:</div>";

    //wizyty

    $queyVisits = "SELECT Visits.room, Visits.id, Visits.time
              FROM Visits
              WHERE Visits.doctor_id = {$row[0]} AND Visits.status = 'za' AND Visits.date = UTC_DATE()
              ORDER BY Visits.time
              LIMIT 5";

    $visits = mysqli_query($server, $queyVisits) or die ("Zle sformulowane query");

    while ($wizyta = mysqli_fetch_array($visits)) // lista lekarzy
    {
        $czasBezsekund =  substr($wizyta[2],0,5);
        echo   "<div  class=\"divTableCell wizyty \">$wizyta[0]<br>
        <span class=\"bold\">$wizyta[1]</span><br>$czasBezsekund</div>";
    }

    echo  "</div>"; //tr
}

echo "</div>"; //table

//i tu wypadaloby zamknac polaczenie z baza funkcja z pliku fann_get_total_connections

?>


  </body>
</html>
