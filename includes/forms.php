<div class="startContainer">
  <div class="startContainer__logo">
    <h1>Gradebook</h1><img src="/assets/icons/mortarboard.svg" alt="logo">
  </div>
  <form class="form form--signin" action="../functions/signin.php" method="post">

    <?php
    if (isset($_SESSION['formInfos'])) {
      foreach ($_SESSION['formInfos'] as $key => $info) {
        echo <<<HTML
        <div class="form__info form__info--{$key}">{$info}</div>
        HTML;
        unset($_SESSION['formInfos'][$key]);
      }
    }
    ?>
    <input type="email" name="email" autocomplete="email" placeholder="E-mail" required>
    <input type="password" name="password" autocomplete="current-password" maxlength="32" placeholder="Password" required>
    <button type="submit" class="form__submit form__submit--signin">Sign in</button>
    <p class="form__textButton form__textButton--resetPassword">I forgot my password</p>
  </form>

  <form class="form form--signup" action="../functions/signup.php" method="post">
    <div class="form__tab form__tab--personal">
      <select name="type" required>
        <option value="student" selected>Student</option>
        <option value="teacher">Teacher</option>
      </select>
      <input type="text" name="firstName" autocomplete="given-name" placeholder="First Name" maxlength="100" required>
      <input type="text" name="lastName" autocomplete="family-name" placeholder="Last Name" maxlength="100" required>
      <select name="class" required>
        <option value="" selected disabled hidden>Class</option>
        <?php
        foreach ($_SESSION['classes'] as $class) {
          echo "<option value='{$class}'>{$class}</option>";
        }
        ?>
      </select>
      <input type="text" name="phone" autocomplete="tel" placeholder="Phone" pattern="^[0-9]{9}$" disabled>
      <button class="form__button form__button--next" type="submit">Next</button>
    </div>
    <div class="form__tab form__tab--login">
      <input type="email" name="email" autocomplete="email" placeholder="E-mail">
      <input type="password" name="password" autocomplete="new-password" minlength="8" maxlength="32" placeholder="Password">
      <input type="password" name="confirmPassword" autocomplete="new-password" minlength="8" maxlength="32" placeholder="Password confirmation">
      <button class="form__button form__button--prev" type="button">Back</button>
      <button type="submit" class="form__submit form__submit--signup">Sign up</button>
    </div>
  </form>

  <form class="form form--resetPassword" action="../functions/resetPassword.php" method="POST">
    <input type="email" name="email" autocomplete="email" placeholder="E-mail" required>
    <input type="text" name="firstName" autocomplete="given-name" placeholder="First Name" max="100" required>
    <input type="text" name="lastName" autocomplete="family-name" placeholder="Last Name" max="100" required>
    <button type="submit" class="form__submit form__submit--resetPassword">Reset password</button>
  </form>

  <div class="form__changeForm">
    <p>You do not have an account?</p>
    <p class="form__textButton form__textButton--changeForm">Sign up!</p>
  </div>
  <div class="startContainer__image startContainer__image--left"><img src="/assets/img/start_image2.svg" alt="School image"></div>
  <div class="startContainer__image startContainer__image--right"><img src="/assets/img/start_image1.svg" alt="School image"></div>

</div>