<?php
  include '../../serp_config.php';
  include 'php/utils/connection.php';

  if (isset($_COOKIE['serp_user_email']) || isset($_COOKIE['serp_user_token'])) {

    mysqli_query($server, "DELETE FROM Logins WHERE token = '".$_COOKIE['serp_user_token']."'");

    setcookie('serp_user_email');
    setcookie('serp_user_token');
    setcookie('serp_user_firstname');
    setcookie('serp_user_lastname');
    setcookie('serp_user_type');
  }

  echo "<script type='text/javascript'>
          window.location = '/';
        </script>";
?>
