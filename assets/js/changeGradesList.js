const tabHeaders = document.querySelectorAll(".studentContainer__tabHeader");

const changeHeader = index => {
  const left = index * 50;
  const gradesPanel = document.querySelector(".studentContainer--grades");
  const panelChildren = gradesPanel.querySelectorAll(`:scope > div:not(:first-child)`);

  gsap.to(".studentContainer__activeBar", { left: `${left}%`, x: `-${left}%` });
  tabHeaders.forEach(header => header.classList.remove("active"));
  tabHeaders[index].classList.add("active");

  panelChildren.forEach(child => (child.style.display = "none"));
  gradesPanel.querySelector(`:scope > div:nth-child(${index + 2})`).style.display = "block";
};

tabHeaders.forEach((header, index) => {
  header.addEventListener("click", () => changeHeader(index));
});
