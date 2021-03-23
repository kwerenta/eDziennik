<?php
session_start();
if (!isset($_SESSION["user"])) {
  header("Location: http://{$_SERVER['HTTP_HOST']}/");
}
require '../view.php';
require_once '../config.php';
$header = new View('header');
$header->allocate('scripts', ['clock', GSAP, 'changeSelection']);
$header->render();

$navbar = new View('navbar');
$navbar->render();

?>

<main class="teacherDashboard">
  <div class="teacherContainer teacherContainer--classSelection">
    <h1 class="selection__title selection__title--class">Wybierz klasę</h1>
    <div class="selection__list selection__list--class">
      <div class="selection__content selection__content--class">
        <?php
        foreach ($_SESSION['classes'] as $class) {
          echo "<div class='selection__item selection__item--class'>{$class}</div>";
        }
        ?>
      </div>
    </div>
  </div>
  <div class="teacherContainer teacherContainer--subjectSelection">
    <h1 class="selection__title selection__title--subject">Wybierz przedmiot</h1>
    <div class="selection__list selection__list--subject">
      <div class="selection__content selection__content--subject">
        <?php
        foreach ($_SESSION['subjects'] as $index => $subject) {
          echo "<div class='selection__item selection__item--subject' data-subjectid='{$index}'>{$subject['name']}</div>";
        }
        ?>
      </div>
    </div>
  </div>
</main>