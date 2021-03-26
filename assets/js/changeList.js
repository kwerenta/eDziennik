const tabHeaders = document.querySelectorAll(".menu__tabHeader");

const changeHeader = index => {
  const left = index * 50;
  const panel =
    document.querySelector(".studentContainer--grades") ||
    document.querySelector(".adminContainer--users") ||
    document.querySelector(".teacherContainer--grades");
  const panelChildren = panel.querySelectorAll(`:scope > div:not(:first-child)`);
  const changeChild = panel.querySelector(`:scope > div:nth-child(${index + 2})`);
  const activeBar = document.querySelector(".menu__activeBar");

  gsap
    .timeline()
    .to(activeBar, 0.25, { scaleX: 1.25 })
    .to(panel, 0.25, { clipPath: "inset(-10% -10% 80% -10%)" }, "-=.25")
    .to(activeBar, 0.5, { left: `${left}%`, x: `-${left}%` }, "-=.25")
    .to(panel, 0.25, { clipPath: "inset(-10% -10% -10% -10%)" })
    .to(activeBar, 0.25, { scaleX: 1 }, "-=.5");
  tabHeaders.forEach(header => header.classList.remove("menu__tabHeader--active"));
  tabHeaders[index].classList.add("menu__tabHeader--active");

  setTimeout(() => {
    panelChildren.forEach(child => (child.style.display = "none"));
    changeChild.style.display = "block";
  }, 250);
};

tabHeaders.forEach((header, index) => {
  header.addEventListener("click", () => changeHeader(index));
});
