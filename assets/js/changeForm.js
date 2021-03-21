const nextTab = document.querySelector(".form__button--next");
const prevTab = document.querySelector(".form__button--prev");

const personalTab = document.querySelector(".form__tab--personal");
const personalInputs = document.querySelectorAll(".form__tab--personal > input:not([name='phone'])");
const accountType = document.querySelector(".form__tab--personal > select[name='type']");
const phoneInput = document.querySelector(".form__tab--personal > input[name='phone']");
const classInput = document.querySelector(".form__tab--personal > select[name='class']");

const signupButton = document.querySelector(".form__submit--signup");
const changeFormText = document.querySelector(".form__changeForm > p");
const changeFormButton = document.querySelector(".form__textButton--changeForm");
const resetPasswordButton = document.querySelector(".form__textButton--resetPassword");
const resetPasswordSubmit = document.querySelector(".form__submit--resetPassword");
const cssVariables = document.documentElement;
let resetPassword = false;

const changeText = () => {
  if (changeFormText.innerText == "Nie masz konta?") {
    changeFormText.innerText = resetPassword ? "Pamiętasz hasło?" : "Masz już konto?";
    changeFormButton.innerText = "Zaloguj się!";
  } else {
    changeFormText.innerText = "Nie masz konta?";
    changeFormButton.innerText = "Zarejestruj się!";
  }
};

const signInUp = gsap.timeline({ paused: true });
signInUp
  .to([".form--signin", ".form__changeForm"], { clipPath: "inset(0% 100%)", duration: 0.25 })
  .set(".form--signin", { display: "none" }, ">")
  .set(".form--signup", { display: "flex" })
  .to([".form--signup", ".form__changeForm"], { clipPath: "inset(0% 0%)", duration: 0.25 });

changeFormButton.addEventListener("click", () => {
  let color = "";
  const formError = document.querySelector(".form__error");

  if (resetPassword) {
    resetPasswordLogin.reverse();
    resetPassword = false;
  } else {
    if (cssVariables.style.getPropertyValue("--bg-color") == "var(--secondary-bg-color)") {
      color = "--primary-bg-color";
      signInUp.reverse();
    } else {
      color = "--secondary-bg-color";
      signInUp.play();
    }
    cssVariables.style.setProperty("--bg-color", `var(${color})`);
  }
  setTimeout(() => {
    changeText();
    formError?.remove();
  }, 300);
});

const personalLoginData = gsap.timeline({ paused: true });
personalLoginData
  .to(".form__tab--personal", { clipPath: "inset(0% 100%)", duration: 0.25 })
  .set(".form__tab--personal", { display: "none" }, ">")
  .set(".form__tab--login", { display: "flex" })
  .to(".form__tab--login", { clipPath: "inset(0% 0%)", duration: 0.25 });

nextTab.addEventListener("click", () => {
  let isEmpty = false;
  const inputsArray = Array.from(personalInputs);
  inputsArray.push(accountType.value === "student" ? classInput : phoneInput);

  inputsArray.forEach(input => {
    if (!input.value) {
      isEmpty = true;
      input.classList.add("error");
    } else {
      input.classList.remove("error");
    }
  });

  if (!isEmpty) personalLoginData.play();
});

prevTab.addEventListener("click", () => {
  personalLoginData.reverse();
});

accountType.addEventListener("change", e => {
  phoneInput.style.display = e.target.value === "student" ? "none" : "block";
  classInput.style.display = e.target.value === "student" ? "block" : "none";
});

const resetPasswordLogin = gsap.timeline({ paused: true });
resetPasswordLogin
  .to([".form--signin", ".form__changeForm"], { clipPath: "inset(0% 100%)", duration: 0.25 })
  .set(".form--signin", { display: "none" }, ">")
  .set(".form--resetPassword", { display: "flex" })
  .to([".form--resetPassword", ".form__changeForm"], { clipPath: "inset(0% 0%)", duration: 0.25 });

resetPasswordButton.addEventListener("click", e => {
  resetPasswordLogin.play();
  resetPassword = true;
  setTimeout(() => {
    changeText();
  }, 300);
});

resetPasswordSubmit.addEventListener("click", e => {
  e.preventDefault();
  let isEmpty = false;
  const form = document.querySelector(".form--resetPassword");
  const inputsArray = form.querySelectorAll("input");

  inputsArray.forEach(input => {
    if (!input.value) {
      isEmpty = true;
      input.classList.add("error");
    } else {
      input.classList.remove("error");
    }
  });

  if (!isEmpty) form.submit();
});
