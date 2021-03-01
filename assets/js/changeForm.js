const changeForm = document.querySelector(".changeFormButton");
const nextTab = document.querySelector(".signButton.next");
const prevTab = document.querySelector(".signButton.prev");

const personalInputs = document.querySelectorAll(".personalData > input");

const changeFormText = document.querySelector(".changeFormText > p");
const changeFormButton = document.querySelector(".changeFormButton");
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
tl.to([".signInForm", ".changeFormText"], { opacity: 0, duration: 0.25 })
  .set(".signInForm", { display: "none" }, "+=0.25")
  .set(".signUpForm", { display: "flex" })
  .to([".signUpForm", ".changeFormText"], { opacity: 1, duration: 0.25 }, "+=0.25");

changeForm.addEventListener("click", () => {
  let color;
  if (cssVariables.style.getPropertyValue("--bg-color") == "var(--secondary-bg-color)") {
    color = "--primary-bg-color";
    tl.reverse();
  } else {
    color = "--secondary-bg-color";
    tl.play();
  }
  setTimeout(() => changeText(), 750);
  cssVariables.style.setProperty("--bg-color", `var(${color})`);
});

const timeline = gsap.timeline({ paused: true });
timeline
  .to(".personalData", { opacity: 0, duration: 0.25 })
  .set(".personalData", { display: "none" }, "+=0.25")
  .set(".loginData", { display: "flex" })
  .to(".loginData", { opacity: 1, duration: 0.25 }, "+=0.25");

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
