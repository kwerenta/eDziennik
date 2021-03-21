<div class="startContainer">
  <div class="startContainer__logo">
    <h1>eDziennik</h1>
  </div>
  <form class="form form--signin" action="../functions/signin.php" method="post">

    <?php if (isset($_SESSION['formErrors'])) {
      echo <<<HTML
      <div class="form__error">{$_SESSION['formErrors']}</div>
      HTML;
      unset($_SESSION['formErrors']);
    } ?>
    <input type="text" name="email" autocomplete="email" placeholder="E-mail" required>
    <input type="password" name="password" autocomplete="current-password" placeholder="Hasło" required>
    <button type="submit" class="form__submit form__submit--signin">Zaloguj się</button>
    <p class="form__textButton form__textButton--resetPassword">Nie pamiętam hasła</p>
  </form>

  <form class="form form--signup" action="../functions/signup.php" method="post">
    <div class="form__tab form__tab--personal">
      <select name="type">
        <option value="student" selected>Uczeń</option>
        <option value="teacher">Nauczyciel</option>
      </select>
      <input type="text" name="firstName" autocomplete="given-name" placeholder="Imię">
      <input type="text" name="lastName" autocomplete="family-name" placeholder="Nazwisko">
      <select name="class">
        <option value="" selected disabled hidden>Klasa</option>
        <?php
        $letters = ['A', 'B', 'C', 'D'];
        $numbers = ['1', '2', '3', '4'];
        foreach ($numbers as $number) {
          foreach ($letters as $letter) {
            $class = $number . $letter;
            echo "<option value='{$class}'>{$class}</option>";
          }
        }
        ?>
      </select>
      <input type="text" name="phone" autocomplete="tel" placeholder="Numer telefonu">
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

  <form class="form form--resetPassword" action="../functions/resetPassword.php" method="POST">
    <input type="text" name="email" autocomplete="email" placeholder="E-mail" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>
    <input type="text" name="firstName" autocomplete="given-name" placeholder="Imię" required>
    <input type="text" name="lastName" autocomplete="family-name" placeholder="Nazwisko" required>
    <button type="submit" class="form__submit form__submit--resetPassword">Zresetuj hasło</button>
  </form>

  <div class="form__changeForm">
    <p>Nie masz konta?</p>
    <p class="form__textButton form__textButton--changeForm">Zarejestruj się!</p>
  </div>
  <div class="startContainer__image startContainer__image--left"><img src="/assets/img/start_image1.svg" alt="School image"></div>
  <div class="startContainer__image startContainer__image--right"><img src="/assets/img/start_image2.svg" alt="School image"></div>

</div>