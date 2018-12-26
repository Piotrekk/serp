<?php
  include 'php/utils/connection.php';
?>
<!DOCTYPE html>
<html lang="pl" dir="ltr">
  <head>
    <meta http-equiv="refresh" content="30">
    <link rel="stylesheet" href="css/styleKF.css">
    <meta charset="utf-8">
    <?php
    include 'js/time.js';
     ?>
    <title></title>
  </head>
  <body>

    <table class="tableMain">
      <tr>
    <td colspan="7" class="divTopRight">
      <SCRIPT LANGUAGE= "JavaScript" type= "text/javascript">
      time()
      </SCRIPT>
    </td>
  </tr>

<?php

$queryDoctorList = 'SELECT Visits.doctor_id, Users.last_name, Users.first_name
                    FROM Visits, Users
                    WHERE Users.id = Visits.doctor_id AND Visits.date = UTC_DATE()
                    GROUP BY doctor_id';

$doctorList = mysqli_query($server, $queryDoctorList) or die ("Zle sformulowane query");

//lekarze
while ($row = mysqli_fetch_array($doctorList))
{
    echo "<tr>";
    echo "<td class=\"lekarze\">dr. $row[1] $row[2]</td>";

    echo "<td class=\"wizyty\">Gabitent:<br/>Numer:<br/>Godzina:</td>";

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
        echo   "<td  class=\"wizyty\">$wizyta[0]<br><span class=\"bold\">$wizyta[1]</span><br>$czasBezsekund</td>";
    }

    echo  "</tr>";
}

echo "</table>"

//i tu wypadaloby zamknac polaczenie z baza funkcja z pliku fann_get_total_connections

?>
    </div>
    </div>

  </body>
</html>
