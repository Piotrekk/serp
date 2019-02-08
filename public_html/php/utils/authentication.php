<?php
  function resetLoginRedirectToLoginPage() {
    $isLogged = false;
    echo "<script type='text/javascript'>
            window.location = '/login.php';
          </script>";
  }

  if (empty($_COOKIE["serp_user_email"]) || empty($_COOKIE["serp_user_token"])) {
    resetLoginRedirectToLoginPage();
  } else {
    $userQuery = mysqli_query($server, "SELECT id FROM Users WHERE email LIKE '{$_COOKIE["serp_user_email"]}'") or die ("Zle sformulowane query");
    $userResult = mysqli_fetch_assoc($userQuery);

    $userId = array_values($userResult)[0];

    $loginQuery = mysqli_query($server, "SELECT Users.email, Logins.token FROM Logins INNER JOIN Users ON Logins.user_id = Users.id WHERE Users.id = {$userId}") or die ("Zle sformulowane query");
    $loginResult = mysqli_fetch_assoc($loginQuery);

    if (array_values($loginResult)[0] == $_COOKIE["serp_user_email"]
      && array_values($loginResult)[1] == $_COOKIE["serp_user_token"]) {
        $isLogged = true;
      } else {
        resetLoginRedirectToLoginPage();
      }
  }
?>
