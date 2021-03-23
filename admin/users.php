<?php
session_start();
require '../functions/isLoggedIn.php';
require '../functions/getUsers.php';
require '../view.php';
require_once '../config.php';
$header = new View('header');
$header->allocate('scripts', ['clock', 'changeList', GSAP, 'overlay']);
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
    <?php
    foreach (array_keys($users) as $type) {
      $lastTitle = $type === "students" ? "Klasa" : "Numer Telefonu";
      $lastInput = $type === "students" ? "class" : "phone";
      echo <<<HTML
          <div class='users__list users__list--{$type}'>
            <div class="users__item users__item--{$type}">
              <h2>E-Mail</h2>
              <h2>Imię</h2>
              <h2>Nazwisko</h2>
              <h2>{$lastTitle}</h2>
              <h2>Aktywny</h2>
            </div>
        HTML;
      foreach ($users[$type] as $user) {
        $isActivated = $user['isActivated'] === "1" ? "Tak" : "Nie";
        echo <<<HTML
          <div data-id={$user['id']} data-typeid={$user['type_id']} data-isActivated={$user['isActivated']} class="users__item users__item--{$type}">
            <h3 class="users__data users__data--email">{$user['email']}</h3>
            <p class="users__data users__data--firstName">{$user['first_name']}</p>
            <p class="users__data users__data--lastName">{$user['last_name']}</p>
            <p class="users__data users__data--{$lastInput}">{$user['last_field']}</p>
            <p class="users__data users__data--isActivated">{$isActivated}</p>
          </div>
          HTML;
      }
      echo "</div>";
    }
    ?>
  </div>
  <div class="overlay">
    <div class="overlay__content">
      <h1 class="overlay__header">Edycja użytkownika</h1>
      <form class="form form--overlay" method="POST">
        <input disabled type="text" name="email" placeholder="E-Mail">
        <input type="text" name="first_name" placeholder="Imię">
        <input type="text" name="last_name" placeholder="Nazwisko">
        <input type="text" name="phone" placeholder="Numer telefonu">
        <select name="class">
          <option value="" selected disabled hidden>Klasa</option>
          <?php
          $numbers = ['1', '2', '3', '4'];
          $letters = ['A', 'B', 'C', 'D'];
          foreach ($numbers as $number) {
            foreach ($letters as $letter) {
              $class = $number . $letter;
              echo "<option value='{$class}'>{$class}</option>";
            }
          }
          ?>
        </select>
        <input type="hidden" name="id" value="">
        <input type="hidden" name="typeid" value="">
        <input type="hidden" name="isActivated" value="">
        <button class="form__submit form__submit--edit" type="submit">Edytuj</button>
        <button class="form__submit form__submit--delete" type="submit">
          <h4>Zablokuj</h4>
        </button>
        <button class="form__button form__button--close">Anuluj</button>
      </form>
    </div>
  </div>
</main>