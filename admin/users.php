<?php
session_start();
require '../functions/isLoggedIn.php';
require '../functions/getUsers.php';
require '../view.php';
require_once '../config.php';
$header = new View('header');
$header->allocate('scripts', ['clock', GSAP, 'overlay', 'changeList', 'snackalert']);
$header->render();

$navbar = new View('navbar');
$navbar->render();

if (isset($_SESSION['snackalert'])) {
  $snackalert = new View('snackalert');
  $snackalert->allocate('alert', [$_SESSION['snackalert']['type'], $_SESSION['snackalert']['text']]);
  $snackalert->render();
  unset($_SESSION['snackalert']);
}
$_SESSION['deactivatedOnly'] = 0;
if (isset($_GET['deactivatedOnly'])) $_SESSION['deactivatedOnly'] = -1;
$users = getUsers($_SESSION['deactivatedOnly']);
?>
<main>
  <div class="adminContainer adminContainer--users">
    <div class="menu__tabs">
      <h2 class="menu__tabHeader menu__tabHeader--active">Students</h2>
      <h2 class="menu__tabHeader">Teachers</h2>
      <h2 class="menu__tabHeader">Admins</h2>
      <div class="menu__activeBar"></div>
    </div>
    <?php
    foreach (array_keys($users) as $type) {
      $lastInput = $type === "students" ? "class" : "phone";
      $lastTitle = ucfirst($lastInput);
      echo <<<HTML
          <div class='users__list users__list--{$type}'>
            <div class="users__item users__item--{$type}">
              <h2>E-Mail</h2>
              <h2>First Name</h2>
              <h2>Last Name</h2>
              <h2>{$lastTitle}</h2>
              <h2>Active?</h2>
            </div>
        HTML;
      foreach ($users[$type] as $user) {
        $isActivated = $user['isActivated'] === "1" ? "Yes" : "No";
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
      <h1 class="overlay__header">Edit user</h1>
      <form class="form form--overlay" action="../functions/editUser.php" method="POST">
        <input type="email" name="email" placeholder="E-Mail" required>
        <input type="text" name="first_name" placeholder="First Name" maxlength="100" required>
        <input type="text" name="last_name" placeholder="Last Name" maxlength="100" required>
        <input type="text" name="phone" placeholder="Phone" pattern="^[0-9]{9}$">
        <select name="class">
          <option value="" selected disabled hidden>Class</option>
          <?php
          foreach ($_SESSION['classes'] as $class) {
            echo "<option value='{$class}'>{$class}</option>";
          }
          ?>
        </select>
        <input type="hidden" name="id" value="">
        <input type="hidden" name="typeid" value="">
        <input type="hidden" name="isActivated" value="">
        <button class="form__submit form__submit--edit" type="submit">Edit</button>
        <button class="form__submit form__submit--delete" type="submit">
          <h4>Deactivate</h4>
        </button>
        <button class="form__button form__button--close">Cancel</button>
      </form>
    </div>
  </div>
</main>