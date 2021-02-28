const changeForm = document.querySelector(".changeFormButton");
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
tl.to([".signInForm", ".changeFormText"], { opacity: 0, duration: 0.25, onComplete: changeText })
  .set(".signInForm", { display: "none" }, "+=0.25")
  .set(".signUpForm", { display: "flex" })
  .to([".signUpForm", ".changeFormText"], { opacity: 1, duration: 0.25, onComplete: changeText }, "+=0.25");
changeForm.addEventListener("click", () => {
  let color;
  if (cssVariables.style.getPropertyValue("--background-color") == "var(--secondary-background-color)") {
    color = "--primary-background-color";
    tl.reverse();
  } else {
    color = "--secondary-background-color";
    tl.play();
  }
  cssVariables.style.setProperty("--background-color", `var(${color})`);
});
