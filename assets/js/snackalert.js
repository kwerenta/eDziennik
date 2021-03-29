const snackalert = document.querySelector(".snackalert");
const closeAlert = document.querySelector(".snackalert__close");

const hideAlert = () => {
  gsap.to(snackalert, { clipPath: "inset(100% 0%" });
};

closeAlert &&
  setTimeout(() => {
    hideAlert();
  }, 10000);

closeAlert?.addEventListener("click", () => {
  hideAlert();
});
