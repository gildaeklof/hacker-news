const showButton = document.querySelector(".form-button");
const hideButton = document.querySelector(".post-button");
const form = document.querySelector(".post-form");

showButton.addEventListener("click", () => {
  if (form.className === "formhidden") {
    form.className = "formunhidden";
  } else {
    form.className = "formunhidden";
    button.value = "unhide";
  }
});

hideButton.addEventListener("click", () => {
  if (form.className === "formunhidden") {
    form.className = "formhidden";
  } else {
    form.className = "formhidden";
    button.value = "hide";
  }
});
