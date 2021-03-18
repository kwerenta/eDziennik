<?php
session_start();
require '../functions/isLoggedIn.php';
require '../functions/getUsers.php';
require '../view.php';
$header = new View('header');
$header->allocate('scripts', ['clock', 'changeList', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.6.0/gsap.min.js', 'overlay']);
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

      echo <<<HTML
          <div class='users__list users__list--{$type}'>
            <div class="users__item users__item--{$type}">
              <h2>E-Mail</h2>
              <h2>Imię</h2>
              <h2>Nazwisko</h2>
            </div>
        HTML;
      foreach ($users[$type] as $user) {
        echo <<<HTML
          <div data-id={$user['id']} data-typeid={$user['type_id']} class="users__item users__item--{$type}">
            <h3>{$user['email']}</h3>
            <p>{$user['first_name']}</p>
            <p>{$user['last_name']}</p>
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
      <form class="form form--overlay" method="POST" action="/functions/editUser.php">
        <input disabled type="text" name="email" placeholder="E-Mail">
        <input type="text" name="first_name" placeholder="Imię">
        <input type="text" name="last_name" placeholder="Nazwisko">
        <button class="form__submit form__submit--edit" type="submit">Edytuj</button>
        <button class="form__submit form__submit--delete" type="submit">Usuń</button>
        <button class="form__button form__button--close">Anuluj</button>
      </form>
    </div>
  </div>
</main>