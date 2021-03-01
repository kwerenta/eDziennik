<div class="startContainer">
  <div class="logo">
    <h1>eDziennik</h1>
  </div>
  <form class="form signInForm" method="post">
    <input type="text" name="email" autocomplete="email" placeholder="E-mail" required>
    <input type="password" name="password" autocomplete="current-password" placeholder="Hasło" required>
    <button type="submit" class="signButton signin">Zaloguj się</button>
    <p class="noPassword">Nie pamiętam hasła</p>
  </form>

  <form class="form signUpForm" method="post">
    <div class="formTab personalData">
      <input type="text" name="firstName" autocomplete="given-name" placeholder="Imię" required>
      <input type="text" name="lastName" autocomplete="family-name" placeholder="Nazwisko" required>
      <input type="tel" name="phone" autocomplete="tel" pattern="[0-9]{9}" placeholder="Telefon" required>
      <button class="signButton next" onclick="event.preventDefault();">Przejdź dalej</button>
    </div>
    <div class="formTab loginData">
      <input type="text" name="email" autocomplete="email" placeholder="E-mail">
      <input type="password" name="password" autocomplete="new-password" placeholder="Hasło">
      <input type="password" name="confirmPassword" autocomplete="new-password" placeholder="Potwierdź hasło">
      <button class="signButton prev" onclick="event.preventDefault();">Wróć</button>
      <button type="submit" disabled class="signButton signup">Zarejestruj się</button>
    </div>
  </form>

  <div class="changeFormText">
    <p>Nie masz konta?</p>
    <p class="changeFormButton">Zarejestruj się!</p>
  </div>
  <div id="leftImage"><img src="/assets/img/start_image1.svg" alt="School image" class="startImage"></div>
  <div id="rightImage"><img src="/assets/img/start_image2.svg" alt="School image" class="startImage"></div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.6.0/gsap.min.js"></script>
<script src="/assets/js/changeForm.js"></script>