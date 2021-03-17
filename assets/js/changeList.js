const tabHeaders = document.querySelectorAll(".menu__tabHeader");

const changeHeader = index => {
  const left = index * 50;
  const panel = document.querySelector(".studentContainer--grades") || document.querySelector(".adminContainer--users");
  const panelChildren = panel.querySelectorAll(`:scope > div:not(:first-child)`);

  gsap.to(".menu__activeBar", { left: `${left}%`, x: `-${left}%` });
  tabHeaders.forEach(header => header.classList.remove("menu__tabHeader--active"));
  tabHeaders[index].classList.add("menu__tabHeader--active");

  panelChildren.forEach(child => (child.style.display = "none"));
  panel.querySelector(`:scope > div:nth-child(${index + 2})`).style.display = "block";
};

tabHeaders.forEach((header, index) => {
  header.addEventListener("click", () => changeHeader(index));
});
