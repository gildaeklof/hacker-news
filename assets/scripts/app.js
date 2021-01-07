const showButton = document.querySelector(".show-button");
const hideButton = document.querySelector(".hide-button");
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
