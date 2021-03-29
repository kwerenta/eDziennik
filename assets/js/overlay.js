const form = document.querySelector(".form--overlay");
const overlay = document.querySelector(".overlay");
const email = overlay.querySelector("input[name='email']");
const firstName = overlay.querySelector("input[name='first_name']");
const lastName = overlay.querySelector("input[name='last_name']");
const phone = overlay.querySelector("input[name='phone']");
const studentClass = overlay.querySelector("select[name='class']");
const idInput = overlay.querySelector("input[name='id']");
const typeidInput = overlay.querySelector("input[name='typeid']");
const isActivated = overlay.querySelector("input[name='isActivated']");
const usersItems = document.querySelectorAll(".users__list:not(.users__list--admins) > .users__item:not(:first-child)");

const gradesItems = document.querySelectorAll(".item__container");
const grade = overlay.querySelector("input[name='grade']");
const category = overlay.querySelector("select[name='category']");
const description = overlay.querySelector("input[name='description']");
const studentId = overlay.querySelector("input[name='student_id']");
const gradeId = overlay.querySelector("input[name='grade_id']");

const closeBtn = document.querySelector(".form__button--close");
const editBtn = document.querySelector(".form__submit--edit");
const deleteBtn = document.querySelector(".form__submit--delete");
const deleteText = deleteBtn.querySelector("h4");

const tl = gsap.timeline({ paused: true });
tl.to(overlay, 0.2, { autoAlpha: 1 }).from(".overlay__content", 0.6, {
  y: -850,
  ease: Elastic.easeOut.config(1, 0.75),
});

gradesItems?.forEach(item => {
  item.addEventListener("click", e => {
    tl.play();
    grade.value = e.currentTarget.dataset.grade;
    category.value = e.currentTarget.dataset.category;
    description.value = e.currentTarget.dataset.description;
    studentId.value = e.currentTarget.dataset.student;
    gradeId.value = e.currentTarget.dataset.gradeid;
  });
});

usersItems?.forEach(item => {
  item.addEventListener("click", e => {
    tl.play();
    idInput.value = e.currentTarget.dataset.id;
    typeidInput.value = e.currentTarget.dataset.typeid;
    isActivated.value = e.currentTarget.dataset.isactivated;

    deleteText.innerText = isActivated.value === "0" ? "Odblokuj" : "Zablokuj";

    if (e.currentTarget.classList.contains("users__item--students")) {
      phone.style.display = "none";
      studentClass.style.display = "block";
      studentClass.value = e.currentTarget.querySelector(`.users__data--class`).innerText;
    } else {
      phone.style.display = "block";
      studentClass.style.display = "none";
      phone.value = e.currentTarget.querySelector(`.users__data--phone`).innerText;
    }

    email.value = e.currentTarget.querySelector(".users__data--email").innerText;
    firstName.value = e.currentTarget.querySelector(".users__data--firstName").innerText;
    lastName.value = e.currentTarget.querySelector(".users__data--lastName").innerText;
  });
});

const deleteAnimation = gsap.timeline({ paused: true });
deleteAnimation.to(deleteText, 0.5, { clipPath: "inset(100% 100%)" }).to(deleteText, 0.5, { clipPath: "inset(0% 0%)" });

const changeText = () => {
  if (deleteAnimation.reversed()) {
    deleteBtn.classList.remove("form__submit--confirm");
    deleteText.innerText = !isActivated ? "Usuń" : isActivated.value === "0" ? "Odblokuj" : "Zablokuj";
  } else {
    deleteBtn.classList.add("form__submit--confirm");
    deleteText.innerText = "Naciśnij, aby potwierdzić";
  }
};

deleteBtn.addEventListener("click", e => {
  e.preventDefault();

  if (["Zablokuj", "Odblokuj", "Usuń"].includes(deleteText.innerText)) {
    deleteAnimation.play();
    setTimeout(() => {
      changeText();
    }, 500);
  } else {
    if (email) {
      form.action = "../functions/deactivateUser.php";
      email.disabled = false;
      (phone.style.display === "block" ? studentClass : phone).disabled = true;
    } else {
      form.action = "../functions/deleteGrade.php";
    }
    form.submit();
  }
});

editBtn.addEventListener("click", e => {
  e.preventDefault();
  let isEmpty = false;
  const inputs = email
    ? [email, firstName, lastName, phone.style.display === "block" ? phone : studentClass]
    : [grade, category];
  inputs.forEach(input => {
    if (!input.value) {
      isEmpty = true;
      input.classList.add("error");
    } else {
      input.classList.remove("error");
    }
  });
  if (!isEmpty) {
    if (email) {
      form.action = "../functions/editUser.php";
      (phone.style.display === "block" ? studentClass : phone).disabled = true;
    } else {
      form.action = "../functions/editGrade.php";
    }
    form.submit();
  }
});

closeBtn.addEventListener("click", e => {
  e.preventDefault();
  deleteAnimation.reverse();
  changeText();
  tl.reverse();
});
