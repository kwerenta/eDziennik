<div class="startContainer">
  <div class="startContainer__logo">
    <h1>eDziennik</h1>
  </div>
  <form class="form form--signin" action="../functions/signin.php" method="post">
    <?php if (isset($_SESSION['signinErrors'])) {
      echo <<<HTML
      <div class="form__error">{$_SESSION['signinErrors']}</div>
      HTML;
      unset($_SESSION['signinErrors']);
    } ?>
    <input type="text" name="email" autocomplete="email" placeholder="E-mail" required>
    <input type="password" name="password" autocomplete="current-password" placeholder="Hasło" required>
    <button type="submit" class="form__submit form__submit--signin">Zaloguj się</button>
    <p class="form__textButton form__textButton--noPassword">Nie pamiętam hasła</p>
  </form>

  <form class="form form--signup" action="../functions/signup.php" method="post">
    <div class="form__tab form__tab--personal">
      <input type="text" name="firstName" autocomplete="given-name" placeholder="Imię">
      <input type="text" name="lastName" autocomplete="family-name" placeholder="Nazwisko">
      <input type="tel" name="class" autocomplete="off" placeholder="Klasa">
      <button class="form__button form__button--next" type="button">Przejdź dalej</button>
    </div>
    <div class="form__tab form__tab--login">
      <input type="text" name="email" autocomplete="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" placeholder="E-mail">
      <input type="password" name="password" autocomplete="new-password" placeholder="Hasło">
      <input type="password" name="confirmPassword" autocomplete="new-password" placeholder="Potwierdź hasło">
      <button class="form__button form__button--prev" type="button">Wróć</button>
      <button type="submit" class="form__submit form__submit--signup">Zarejestruj się</button>
    </div>
  </form>

  <div class="form__changeForm">
    <p>Nie masz konta?</p>
    <p class="form__textButton form__textButton--changeForm">Zarejestruj się!</p>
  </div>
  <div class="startContainer__image startContainer__image--left"><img src="/assets/img/start_image1.svg" alt="School image"></div>
  <div class="startContainer__image startContainer__image--right"><img src="/assets/img/start_image2.svg" alt="School image"></div>

</div>