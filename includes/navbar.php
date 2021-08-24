<nav class="navbar">
  <ul class="navbar__list">
    <li class="navbar__logo">
      <a href="/student/" class="navbar__link">
        <span class="navbar__text">Gradebook</span>
        <?php echo file_get_contents("../assets/icons/angle-double-left-solid.svg") ?>
      </a>
    </li>

    <?php
    $options[] = array("name" => "Dashboard", "icon" => "chalkboard");

    if ($_SESSION['user']['rank'] === "admin") {
      $options[] = array("name" => "Users", "icon" => "users", "file" => "users");
      $options[] = array("name" => "Deactivated", "icon" => "lock", "file" => "users", "get" => "deactivatedOnly=true");
    } else {
      $options[] = array("name" => "Grades", "icon" => "award", "file" => "grades");
      $options[] = array("name" => "Notes", "icon" => "theater-masks", "file" => "notes");
    }
    if ($_SESSION['user']['rank'] === "student") $options[] = array("name" => "Timetable", "icon" => "calendar-alt", "file" => "timetable");
    if ($_SESSION['user']['rank'] === "teacher") $options[] = array("name" => "Selection panel", "icon" => "edit", "file" => "selection");

    $options[] = array("name" => "Account settings", "icon" => "user-cog", "file" => "settings");

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
        <span class="navbar__text">Log out</span>
      </a>
      </>
  </ul>
</nav>
<div class="navbar__topbar">
  <h1 class="navbar__title">
    <?php
    switch (basename($_SERVER["SCRIPT_FILENAME"])) {
      case 'grades.php':
        $title = "Grades";
        break;
      case 'notes.php':
        $title = "Notes";
        break;
      case 'users.php':
        $title = "Users";
        break;
      case 'selection.php':
        $title = "Selection panel";
        break;
      case 'settings.php':
        $title = "Account settings";
        break;
      case 'timetable.php':
        $title = "Timetable";
        break;
      default:
        $title = "Dashboard";
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