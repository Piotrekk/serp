<header class="c-header">
  <div class="h-inner u-height--full u-display--flex u-align-items--center">

    <?php
      if (isset($isLogged) && $isLogged) {
        echo "<a href='/app/app.php' class='c-header__logo'>";
      } else {
        echo "<a href='/' class='c-header__logo'>";
      }
    ?>
      <?php
        include 'svg/svg_patient.php';
      ?>
      <h1>System Elektronicznej Rejestracji Pacjenta</h1>
    </a>

    <ul>
      <li>
        <?php
          if (isset($isLogged) && $isLogged) {
            echo "<a href='/logout.php' class='button button--color-blue'>"
                    ."Wyloguj się"."
                  </a>";
          } else {
            echo "<a href='/login.php' class='button button--color-blue'>"
                    ."Zaloguj się"."
                  </a>";
          }
        ?>
      </li>
    </ul>

  </div>
</header>
