<?php
  include '../../serp_config.php';
  include 'php/utils/connection.php';
?>

<!DOCTYPE html>

<html>
  <head>
    <title>SERP - System Elektronicznej Rejestracji Pacjenta</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/time.js"></script>
    <meta http-equiv="refresh" content="30">
  </head>

  <body>

    <section class="p-waiting-room">
      <div class="p-waiting-room__time">
        <script type="text/javascript">
          time()
        </script>
      </div>

      <div class="p-waiting-room__visits">
        <?php

          $queryDoctorList = "SELECT Visits.doctor_id, Users.last_name, Users.first_name
                              FROM Visits, Users
                              WHERE Users.id = Visits.doctor_id /*AND Visits.date = UTC_DATE()*/
                              GROUP BY doctor_id";

          $doctorList = mysqli_query($server, $queryDoctorList) or die ("Zle sformulowane query");

          while ($row = mysqli_fetch_array($doctorList)) {
            echo "<div class='p-waiting-room__visits__visit'>";
            echo "<div class='p-waiting-room__visits__visit__cell u-font-weight--600 u-font-size--45'>
                   <span>Dr $row[1] $row[2]</span>
                 </div>";

            echo "<div class='p-waiting-room__visits__visit__cell u-padding--10 u-font-size--30'>
                    <span>Gabitent:</span>
                    <span>Numer:</span>
                    <span>Godzina:</span>
                  </div>";

            // visits
            $queyVisits = "SELECT Visits.room, Visits.id, Visits.time
                           FROM Visits
                           WHERE Visits.doctor_id = {$row[0]} AND Visits.status = 'za' /*AND Visits.date = UTC_DATE()*/
                           ORDER BY Visits.time
                           LIMIT 5";

            $visits = mysqli_query($server, $queyVisits) or die ("Zle sformulowane query");

            // doctors list
            while ($visit = mysqli_fetch_array($visits)) {
              $hour = substr($visit[2],0,5);
              echo "<div class='p-waiting-room__visits__visit__cell u-padding--10 u-font-size--30'>
                      <span>$visit[0]</span>
                      <span class='u-font-weight--600'>$visit[1]</span>
                      <span>$hour</span>
                   </div>";
            }

            echo  "</div>";
          }

        ?>
      </div>
    </section>

  </body>
</html>
