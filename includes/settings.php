<?php $container = $rank . "Container" ?>
<main>
  <div class="<?php echo "{$container} {$container}--settings"; ?>">
    <h1 class="settings__title">Ustawienia konta</h1>
    <div class="settings__forms">
      <form action="../functions/editPasword.php" class="form form--settings" method="POST">
        <input type="email" name="email" placeholder="E-Mail" autocomplete="email" hidden>
        <input type="password" name="currentPassword" placeholder="Aktualne hasło" autocomplete="current-password" required>
        <input type="password" name="newPassword" placeholder="Nowe hasło" minlength="8" maxlength="32" autocomplete="new-password" required>
        <button class="form__submit form__submit--insert form__submit--newPassword" type="submit">Zmień hasło</button>
      </form>
      <form action="../functions/editEmail.php" class="form form--settings" method="POST">
        <input type="email" name="currentEmail" value="<?php echo $_SESSION['user']['email'] ?>" disabled>
        <input type="email" name="email" placeholder="Nowy E-Mail" autocomplete="email" required>
        <button class="form__submit form__submit--insert form__submit--newPassword" type="submit">Zmień E-Mail</button>
      </form>
    </div>
  </div>
</main>