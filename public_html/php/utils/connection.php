<?php
  $server = mysqli_connect($dbServer, $dbUsername, $dbPassword, $dbName, $dbPort) or die("Could not connect to remote server");
  $db = mysqli_select_db($server, "serpwsb") or die ("Could not connect to remove database");
?>
