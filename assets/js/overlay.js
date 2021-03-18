const overlay = document.querySelector(".overlay");
const email = overlay.querySelector("input[name='email']");
const firstName = overlay.querySelector("input[name='first_name']");
const lastName = overlay.querySelector("input[name='last_name']");
const usersItems = document.querySelectorAll(".users__item");

const closeBtn = document.querySelector(".form__button--close");

const tl = gsap.timeline({ paused: true });
tl.to(overlay, { autoAlpha: 1, duration: 0.3 });

usersItems.forEach(item => {
  item.addEventListener("click", e => {
    tl.play();
    email.value = "wdw";
    firstName.value = "lol";
    lastName.value = "no";
  });
});

closeBtn.addEventListener("click", e => {
  e.preventDefault();
  tl.reverse();
});
