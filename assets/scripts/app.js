//menu

const menubutton = document.querySelector(".icon");
const nav = document.querySelector(".topnav");

menubutton.addEventListener("click", hamMenu);

function hamMenu() {
  if (nav.className === "topnav") {
    nav.className += " responsive";
  } else {
    nav.className = "topnav";
  }
}

//show/hide forms

const showButton = document.querySelector(".show-button");
const hideButtons = document.querySelectorAll(".hide-button");
const form = document.querySelector(".post-form");

if (showButton) {
  showButton.addEventListener("click", () => {
    if (form.classList.contains("formhidden")) {
      form.className = "formunhidden";
    } else {
      form.className = "formunhidden";
      showButton.value = "unhide";
    }
  });
}

if (hideButtons) {
  hideButtons.forEach(function (hideButton) {
    hideButton.addEventListener("click", hideForm);
  });
}

function hideForm() {
  if (form.className === "formunhidden") {
    form.className = "formhidden";
  } else {
    form.className = "formhidden";
    hideButton.value = "hide";
  }
}
