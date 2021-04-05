<?php
session_start();
require '../functions/isLoggedIn.php';
require '../view.php';
require_once '../config.php';
$header = new View('header');
$header->allocate('scripts', ['clock', GSAP, 'snackalert']);
$header->render();

$navbar = new View('navbar');
$navbar->render();

if (isset($_SESSION['snackalert'])) {
  $snackalert = new View('snackalert');
  $snackalert->allocate('alert', [$_SESSION['snackalert']['type'], $_SESSION['snackalert']['text']]);
  $snackalert->render();
  unset($_SESSION['snackalert']);
}

?>

<main>
  <div class="teacherContainer teacherContainer--settings">
    <h1 class="settings__title">Ustawienia konta</h1>
    <div class="settings__forms">
      <form action="../functions/editPasword.php" class="form form--settings" method="POST">
        <input type="email" name="email" placeholder="E-Mail" autocomplete="email" hidden>
        <input type="password" name="currentPassword" placeholder="Aktualne hasło" autocomplete="current-password" required>
        <input type="password" name="newPassword" placeholder="Nowe hasło" minlength="8" maxlength="32" autocomplete="new-password" required>
        <button class="form__submit form__submit--insert form__submit--newPassword" type="submit">Zmień hasło</button>
      </form>
      <form action="" class="form form--settings" method="POST">
        <input type="email" name="currentEmail" value="<?php echo $_SESSION['user']['email'] ?>" disabled>
        <input type="email" name="newEmail" placeholder="Nowy E-Mail" autocomplete="email" required>
        <button class="form__submit form__submit--insert form__submit--newPassword" type="submit">Zmień E-Mail</button>
      </form>
    </div>
  </div>
</main>