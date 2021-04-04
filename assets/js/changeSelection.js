const classContainer = document.querySelector(".teacherContainer--classSelection");
const classList = document.querySelector(".selection__content--class");
const subjectContainer = document.querySelector(".teacherContainer--subjectSelection");
const subjectList = document.querySelector(".selection__content--subject");
const backButton = document.querySelector(".selection__back");

let classChar = "";

const changeSelection = gsap.timeline({ paused: true });
changeSelection
  .fromTo(classContainer, 0.75, { clipPath: "circle(200% at 0% 0%)" }, { clipPath: "circle(0% at 0% 0%)" })
  .set(classContainer, { display: "none" })
  .set(subjectContainer, { display: "flex" })
  .fromTo(
    subjectContainer,
    0.75,
    {
      clipPath: "circle(0% at 0% 0%)",
    },
    {
      clipPath: "circle(200% at 0% 0%)",
    }
  );

classList.addEventListener("click", e => {
  if (e.target.classList.contains("selection__item--class")) {
    classChar = e.target.innerText;
    changeSelection.play();
  }
});

subjectList.addEventListener("click", e => {
  if (e.target.classList.contains("selection__item--subject")) {
    const subjectChar = e.target.dataset.subjectid;
    window.location.href = `/teacher/index.php?class=${classChar}&subject=${subjectChar}`;
  }
});

backButton.addEventListener("click", e => {
  changeSelection.reverse();
});
