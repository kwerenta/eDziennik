const tabHeaders = document.querySelectorAll(".menu__tabHeader");

const changeHeader = index => {
  const left = index * 50;
  const panel =
    document.querySelector(".studentContainer--grades") ||
    document.querySelector(".adminContainer--users") ||
    document.querySelector(".teacherContainer--grades") ||
    document.querySelector(".teacherContainer--notes");
  const panelChildren = panel.querySelectorAll(`:scope > div:not(:first-child)`);
  const changeChild = panel.querySelector(`:scope > div:nth-child(${index + 2})`);
  const activeBar = document.querySelector(".menu__activeBar");

  gsap
    .timeline()
    .to(activeBar, 0.25, { scaleX: 1.25 })
    .to(panel, 0.35, { clipPath: "inset(-10% -10% 88% -10%)", ease: Power1.easeOut }, "-=.25")
    .to(activeBar, 0.5, { left: `${left}%`, x: `-${left}%` }, "-=.35")
    .to(panel, 0.35, { clipPath: "inset(-10% -10% -10% -10%)", ease: Power1.easeIn })
    .to(activeBar, 0.25, { scaleX: 1 }, "-=.6");
  tabHeaders.forEach(header => header.classList.remove("menu__tabHeader--active"));
  tabHeaders[index].classList.add("menu__tabHeader--active");

  setTimeout(() => {
    panelChildren.forEach(child => (child.style.display = "none"));
    changeChild.style.display = "block";
  }, 350);
};

tabHeaders.forEach((header, index) => {
  header.addEventListener("click", () => {
    if (!header.classList.contains("menu__tabHeader--active")) changeHeader(index);
  });
});
