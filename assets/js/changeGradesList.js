const tabHeaders = document.querySelectorAll(".tabHeader");

const changeHeader = index => {
  const left = index * 50;
  gsap.to(".activeBar", { left: `${left}%`, x: `-${left}%` });
  tabHeaders.forEach(header => header.classList.remove("active"));
  tabHeaders[index].classList.add("active");
};

tabHeaders.forEach((header, index) => {
  header.addEventListener("click", () => changeHeader(index));
});
