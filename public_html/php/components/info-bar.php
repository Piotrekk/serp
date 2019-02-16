<?php
  if (
    !empty($_SESSION['lastOpenPFN']) &&
    !empty($_SESSION['lastOpenPLN']) &&
    !empty($_SESSION['lastOpenDate']) &&
    !empty($_SESSION['lastOpenTime']) &&
    !empty($_SESSION['lastOpenRoom']) &&
    !empty($_SESSION['lastOpenDFN']) &&
    !empty($_SESSION['lastOpenDLN'])
  ) {
?>
  <div class="p-reception__last-visit">
    Ostatnia przeglądana wizyta:
    <?php
      echo "Pacjent {$_SESSION['lastOpenPFN']} {$_SESSION['lastOpenPLN']}, {$_SESSION['lastOpenDate']} {$_SESSION['lastOpenTime']}, pokój nr {$_SESSION['lastOpenRoom']}, dr {$_SESSION['lastOpenDFN']} {$_SESSION['lastOpenDLN']}";
    ?>
  </div>
<?php
  }
?>
