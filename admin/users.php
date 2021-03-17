<?php
session_start();
require '../functions/isLoggedIn.php';
require '../functions/getUsers.php';
require '../view.php';
$header = new View('header');
$header->allocate('scripts', ['clock', 'changeList', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.6.0/gsap.min.js']);
$header->render();

$navbar = new View('navbar');
$navbar->render();

$users = getUsers();

?>
<main>
  <div class="adminContainer adminContainer--users">
    <div class="menu__tabs">
      <h2 class="menu__tabHeader menu__tabHeader--active">Uczniowie</h2>
      <h2 class="menu__tabHeader">Nauczyciele</h2>
      <h2 class="menu__tabHeader">Administratorzy</h2>
      <div class="menu__activeBar"></div>
    </div>
    <div class="users__list users__list--students">
      <div class="users__item users__item--students">
        <h2>E-Mail</h2>
        <h2>Imię</h2>
        <h2>Nazwisko</h2>
      </div>
      <?php
      foreach ($users['students'] as $student) {

        echo <<<HTML
          <div class="users__item users__item--students">
            <h3 data-id={$student['id']}>{$student['email']}</h3>
            <p>{$student['first_name']}</p>
            <p>{$student['last_name']}</p>
          </div>
          HTML;
      }
      ?>
    </div>
    <div class="users__list users__list--teachers">
      <div class="users__item users__item--teachers">
        <h2>E-Mail</h2>
        <h2>Imię</h2>
        <h2>Nazwisko</h2>
      </div>
      <?php
      foreach ($users['teachers'] as $teacher) {
        echo <<<HTML
          <div class="users__item users__item--teachers">
            <h3>{$teacher['email']}</h3>
            <p>{$teacher['first_name']}</p>
            <p>{$teacher['last_name']}</p>
          </div>
          HTML;
      }
      ?>
    </div>
    <div class="users__list users__list--admins">
      <div class="users__item users__item--admins">
        <h2>E-Mail</h2>
        <h2>Imię</h2>
        <h2>Nazwisko</h2>
      </div>
      <?php
      foreach ($users['admins'] as $admin) {
        echo <<<HTML
          <div class="users__item users__item--admins">
            <h3>{$admin['email']}</h3>
            <p>{$admin['first_name']}</p>
            <p>{$admin['last_name']}</p>
          </div>
          HTML;
      }
      ?>
    </div>
  </div>
  </div>
</main>