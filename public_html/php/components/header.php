<header class="c-header">
  <div class="h-inner u-height--full u-display--flex u-align-items--center">

    <a href="/">System Elektronicznej Rejestracji Pacjenta</a>

    <ul>
      <li>
        <?php
          if (isset($isLogged) && $isLogged) {
            echo "<a href='/logout.php'>"
                    ."Wyloguj"."
                  </a>";
          } else {
            echo "<a href='/login.php'>"
                    ."Zaloguj"."
                  </a>";
          }
        ?>
      </li>
    </ul>

  </div>
</header>
