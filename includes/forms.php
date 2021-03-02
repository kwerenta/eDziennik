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

  <form class="form signUpForm" action="../functions/register.php" method="post">
    <div class="formTab personalData">
      <input type="text" name="firstName" autocomplete="given-name" placeholder="Imię" required>
      <input type="text" name="lastName" autocomplete="family-name" placeholder="Nazwisko" required>
      <input type="tel" name="class" autocomplete="off" pattern="[1-4]{1}[A-F]{1}" placeholder="Klasa" required>
      <button class="signButton next" onclick="event.preventDefault();">Przejdź dalej</button>
    </div>
    <div class="formTab loginData">
      <input type="text" name="email" autocomplete="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" placeholder="E-mail">
      <input type="password" name="password" autocomplete="new-password" placeholder="Hasło">
      <input type="password" name="confirmPassword" autocomplete="new-password" placeholder="Potwierdź hasło">
      <button class="signButton prev" onclick="event.preventDefault();">Wróć</button>
      <button type="submit" class="signButton signup">Zarejestruj się</button>
    </div>
  </form>

  <div class="changeFormText">
    <p>Nie masz konta?</p>
    <p class="changeFormButton">Zarejestruj się!</p>
  </div>
  <div id="leftImage"><img src="/assets/img/start_image1.svg" alt="School image" class="startImage"></div>
  <div id="rightImage"><img src="/assets/img/start_image2.svg" alt="School image" class="startImage"></div>
</div>