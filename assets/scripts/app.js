const showButton = document.querySelector(".form-button");
const hideButton = document.querySelector(".post-button");
const form = document.querySelector(".post-form");

showButton.addEventListener("click", () => {
  if (form.className === "hidden") {
    form.className = "unhidden";
  } else {
    form.className = "unhidden";
    button.value = "unhide";
  }
});

hideButton.addEventListener("click", () => {
  if (form.className === "unhidden") {
    form.className = "hidden";
  } else {
    form.className = "hidden";
    button.value = "hide";
  }
});
