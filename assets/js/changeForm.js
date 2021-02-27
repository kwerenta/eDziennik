const signup = document.querySelector(".registerButton");
const cssVariables = document.documentElement;
const signUpForm = document.querySelector(".signUpForm");
const signInForm = document.querySelector(".signInForm");
const loginText = document.querySelector(".login");
const registerText = document.querySelector(".register");

signup.addEventListener("click", () => {
  cssVariables.style.setProperty("--background-color", "var(--secondary-background-color)");
  signInForm.style.opacity = "0";
  registerText.style.opacity = "0";
  setTimeout(() => {
    registerText.style.display = "none";
    loginText.style.display = "block";
    signInForm.style.display = "none";
    signUpForm.style.display = "flex";
    setTimeout(() => {
      signUpForm.style.opacity = "1";
      loginText.style.opacity = "1";
    }, 500);
  }, 500);
});
