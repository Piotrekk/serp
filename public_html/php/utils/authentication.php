<?php
  if (empty($_COOKIE["serp_user_email"]) || empty($_COOKIE["serp_user_token"])) {
    $isLogged = false;
    echo "<script type='text/javascript'>
            window.location = '/login.php';
          </script>";
  } else {
    $isLogged = true;
  }
?>
