const tabHeaders = document.querySelectorAll(".grades__tabHeader");

const changeHeader = index => {
  const left = index * 50;
  const gradesPanel = document.querySelector(".studentContainer--grades");
  const panelChildren = gradesPanel.querySelectorAll(`:scope > div:not(:first-child)`);

  gsap.to(".grades__activeBar", { left: `${left}%`, x: `-${left}%` });
  tabHeaders.forEach(header => header.classList.remove("grades__tabHeader--active"));
  tabHeaders[index].classList.add("grades__tabHeader--active");

  panelChildren.forEach(child => (child.style.display = "none"));
  gradesPanel.querySelector(`:scope > div:nth-child(${index + 2})`).style.display = "block";
};

tabHeaders.forEach((header, index) => {
  header.addEventListener("click", () => changeHeader(index));
});
