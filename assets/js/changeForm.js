const nextTab = document.querySelector(".form__button--next");
const prevTab = document.querySelector(".form__button--prev");

const personalInputs = document.querySelectorAll(".form__tab--personal > input");

const changeFormText = document.querySelector(".form__changeForm > p");
const changeFormButton = document.querySelector(".form__textButton--changeForm");
const cssVariables = document.documentElement;

const changeText = () => {
  if (changeFormText.innerHTML == "Nie masz konta?") {
    changeFormText.innerHTML = "Masz już konto?";
    changeFormButton.innerHTML = "Zaloguj się!";
  } else {
    changeFormText.innerHTML = "Nie masz konta?";
    changeFormButton.innerHTML = "Zarejestruj się!";
  }
};

const tl = gsap.timeline({ paused: true });
tl.to([".form--signin", ".form__changeForm"], { clipPath: "inset(0% 100%)", duration: 0.25 })
  .set(".form--signin", { display: "none" }, ">")
  .set(".form--signup", { display: "flex" })
  .to([".form--signup", ".form__changeForm"], { clipPath: "inset(0% 0%)", duration: 0.25 });

changeFormButton.addEventListener("click", () => {
  let color = "";
  const formError = document.querySelector(".form__error");

  if (cssVariables.style.getPropertyValue("--bg-color") == "var(--secondary-bg-color)") {
    color = "--primary-bg-color";
    tl.reverse();
  } else {
    color = "--secondary-bg-color";
    tl.play();
  }

  setTimeout(() => {
    changeText();
    formError?.remove();
  }, 300);
  cssVariables.style.setProperty("--bg-color", `var(${color})`);
});

const timeline = gsap.timeline({ paused: true });
timeline
  .to(".form__tab--personal", { clipPath: "inset(0% 100%)", duration: 0.25 })
  .set(".form__tab--personal", { display: "none" }, ">")
  .set(".form__tab--login", { display: "flex" })
  .to(".form__tab--login", { clipPath: "inset(0% 0%)", duration: 0.25 });

nextTab.addEventListener("click", () => {
  let isEmpty = false;
  personalInputs.forEach(input => {
    if (input.value === "") isEmpty = true;
  });
  if (!isEmpty) timeline.play();
});

prevTab.addEventListener("click", () => {
  timeline.reverse();
});
