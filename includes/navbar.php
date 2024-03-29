<nav class="navbar">
  <ul class="navbar__list">
    <li class="navbar__logo">
      <a href="/student/" class="navbar__link">
        <span class="navbar__text">eDziennik</span>
        <?php echo file_get_contents("../assets/icons/angle-double-left-solid.svg") ?>
      </a>
    </li>

    <?php
    $options[] = array("name" => "Pulpit", "icon" => "chalkboard");

    if ($_SESSION['user']['rank'] === "admin") {
      $options[] = array("name" => "Użytkownicy", "icon" => "users", "file" => "users");
      $options[] = array("name" => "Nieaktywowani", "icon" => "lock", "file" => "users", "get" => "deactivatedOnly=true");
    } else {
      $options[] = array("name" => "Oceny", "icon" => "award", "file" => "grades");
      $options[] = array("name" => "Uwagi", "icon" => "theater-masks", "file" => "notes");
    }
    if ($_SESSION['user']['rank'] === "student") $options[] = array("name" => "Plan lekcji", "icon" => "calendar-alt", "file" => "timetable");
    if ($_SESSION['user']['rank'] === "teacher") $options[] = array("name" => "Panel wyboru", "icon" => "edit", "file" => "selection");

    $options[] = array("name" => "Ustawienia konta", "icon" => "user-cog", "file" => "settings");

    foreach ($options as $option) {
      $icon = file_get_contents("../assets/icons/{$option['icon']}-solid.svg");
      $get = isset($option['get']) ? "?{$option['get']}" : "";
      $file = isset($option['file']) ? $option['file'] . ".php{$get}" : "";
      echo <<<HTML
        <li class="navbar__item">
          <a href="/{$_SESSION['user']['rank']}/{$file}" class="navbar__link">
            {$icon}
            <span class="navbar__text">{$option['name']}</span>
          </a>
        </li>
        HTML;
    }
    ?>
    <li class="navbar__item">
      <a href="../functions/logout.php" class="navbar__link">
        <?php echo file_get_contents("../assets/icons/sign-out-alt-solid.svg") ?>
        <span class="navbar__text">Wyloguj się</span>
      </a>
      </>
  </ul>
</nav>
<div class="navbar__topbar">
  <h1 class="navbar__title">
    <?php
    switch (basename($_SERVER["SCRIPT_FILENAME"])) {
      case 'grades.php':
        $title = "Oceny";
        break;
      case 'notes.php':
        $title = "Uwagi";
        break;
      case 'users.php':
        $title = "Użytkownicy";
        break;
      case 'selection.php':
        $title = "Panel wyboru";
        break;
      case 'settings.php':
        $title = "Ustawienia konta";
        break;
      case 'timetable.php':
        $title = "Plan lekcji";
        break;
      default:
        $title = "Pulpit";
        break;
    }
    echo $title;
    ?>
  </h1>
  <h1 class="navbar__clock">
    <?php
    echo date('H:i:s');
    ?>
  </h1>
</div>