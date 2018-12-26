<?php
//Krz  include '../../serp_config.php';

//  $server = mysqli_connect($dbServer, $dbUsername, $dbPassword, $dbName, $dbPort) or die("Could not connect to remote server");
//  $db = mysqli_select_db($server, "serpwsb") or die ("Could not connect to remove database");


global $server;
$server = mysqli_connect("serpwsb.cba.pl", "serp", "serpWSB2019", "serpwsb", "3306") or die("Nie mozna polaczyc sie z serwerem bazy danych");
    $baza = mysqli_select_db($server, "serpwsb") or die ("Nie mozna polaczyc z baza");

    if (mysqli_connect_errno())
      {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
      }

?>
