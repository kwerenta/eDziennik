<div class="startContainer">
  <div class="logo">
    <h1>eDziennik</h1>
  </div>

  <form class="form signInForm" method="post">
    <input type="text" name="email" autocomplete="email" placeholder="E-mail">
    <input type="password" name="password" autocomplete="current-password" placeholder="Hasło">
    <button type="submit" class="signButton signin">Zaloguj się</button>
    <a href="#">Nie pamiętam hasła</a>
  </form>

  <form class="form signUpForm" method="post">
    <input type="text" name="email" autocomplete="email" placeholder="E-mail">
    <input type="password" name="password" autocomplete="new-password" placeholder="Hasło">
    <input type="password" name="confirmPassword" autocomplete="confirm-password" placeholder="Potwierdź hasło">
    <button type="submit" class="signButton signup">Zarejestruj się</button>
  </form>

  <div class="register">
    <p>Nie masz konta?</p>
    <p class="registerButton">Zarejestruj się!</p>
  </div>

  <div class="login">
    <p>Posiadasz konto?</p>
    <p class="loginButton">Zaloguj się!</p>
  </div>
  <div id="leftImage"><img src="/assets/img/start_image1.svg" alt="School image" class="startImage"></div>
  <div id="rightImage"><img src="/assets/img/start_image2.svg" alt="School image" class="startImage"></div>
</div>
<script src="/assets/js/changeForm.js"></script>