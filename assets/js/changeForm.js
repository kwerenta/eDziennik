const nextTab = document.querySelector(".form__button--next");
const prevTab = document.querySelector(".form__button--prev");

const personalTab = document.querySelector(".form__tab--personal");
const personalInputs = document.querySelectorAll(".form__tab--personal > input:not([name='phone'])");
const accountType = document.querySelector(".form__tab--personal > select[name='type']");
const phoneInput = document.querySelector(".form__tab--personal > input[name='phone']");
const classInput = document.querySelector(".form__tab--personal > select[name='class']");
const loginInputs = document.querySelectorAll(".form__tab--login > input");

const signupButton = document.querySelector(".form__submit--signup");
const changeFormText = document.querySelector(".form__changeForm > p");
const changeFormButton = document.querySelector(".form__textButton--changeForm");
const resetPasswordButton = document.querySelector(".form__textButton--resetPassword");
const resetPasswordSubmit = document.querySelector(".form__submit--resetPassword");
const newPassword = document.querySelector(".form__newPassword");

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

const isEmpty = inputs => {
  let empty = false;
  inputs.forEach(input => {
    if (!input.value && input.name !== "phone") {
      empty = true;
      input.classList.add("error");
    } else {
      input.classList.remove("error");
    }
  });
  return empty;
};

const changeRequired = (prev, next) => {
  prev.forEach(input => {
    input.required = false;
  });
  next.forEach(input => {
    if (input.name !== "phone") input.required = true;
  });
};

const signInUp = gsap
  .timeline({ paused: true })
  .to([".form--signin", ".form__changeForm"], { clipPath: "inset(0% 100%)", duration: 0.25 })
  .set(".form--signin", { display: "none" }, ">")
  .set(".form--signup", { display: "flex" })
  .to([".form--signup", ".form__changeForm"], { clipPath: "inset(0% 0%)", duration: 0.25 });

changeFormButton.addEventListener("click", () => {
  let color = "";
  const formInfo = document.querySelector(".form__info");

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
    formInfo?.remove();
  }, 300);
});

const personalLoginData = gsap
  .timeline({ paused: true })
  .to(".form__tab--personal", { clipPath: "inset(0% 100%)", duration: 0.25 })
  .set(".form__tab--personal", { display: "none" }, ">")
  .set(".form__tab--login", { display: "flex" })
  .to(".form__tab--login", { clipPath: "inset(0% 0%)", duration: 0.25 });

nextTab.addEventListener("click", e => {
  const inputsArray = Array.from(personalInputs);
  inputsArray.push(accountType.value === "student" ? classInput : phoneInput);

  const isPhoneCorrect = phoneInput.value.match("^[0-9]{6}(?:[0-9]{3})?$");
  if (!isEmpty(inputsArray)) {
    if (phoneInput.value === "" || isPhoneCorrect) {
      changeRequired(inputsArray, loginInputs);
      personalLoginData.play();
      e.preventDefault();
    }
  }
});

prevTab.addEventListener("click", () => {
  const inputsArray = Array.from(personalInputs);
  inputsArray.push(accountType.value === "student" ? classInput : phoneInput);
  personalLoginData.reverse();
  changeRequired(loginInputs, inputsArray);
});

accountType.addEventListener("change", e => {
  if (e.target.value === "student") {
    phoneInput.style.display = "none";
    classInput.style.display = "block";

    phoneInput.disabled = true;

    classInput.required = true;
    classInput.disabled = false;
  } else {
    classInput.style.display = "none";
    phoneInput.style.display = "block";

    classInput.required = false;
    classInput.disabled = true;

    phoneInput.disabled = false;
  }
});

const resetPasswordLogin = gsap
  .timeline({ paused: true })
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

newPassword?.addEventListener("click", e => {
  const formInfo = document.querySelector(".form__info");
  const textInput = document.createElement("textarea");

  textInput.value = e.currentTarget.innerText;
  document.body.appendChild(textInput);
  textInput.select();
  document.execCommand("copy");
  document.body.removeChild(textInput);

  formInfo.innerHTML = "Hasło zostało skopiowane!";
});
