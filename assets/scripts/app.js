const showButton = document.querySelector(".show-button");
const hideButton = document.querySelector(".hide-button");
const cancelButton = document.querySelector(".cancel-button");
const form = document.querySelector(".post-form");

showButton.addEventListener("click", () => {
  if (form.className === "formhidden") {
    form.className = "formunhidden";
  } else {
    form.className = "formunhidden";
    showButton.value = "unhide";
  }
});

hideButton.addEventListener("click", () => {
  if (form.className === "formunhidden") {
    form.className = "formhidden";
  } else {
    form.className = "formhidden";
    hideButton.value = "hide";
  }
});

cancelButton.addEventListener("click", () => {
  if (form.className === "formunhidden") {
    form.className = "formhidden";
  } else {
    form.className = "formhidden";
    cancelButton.value = "hide";
  }
});

//ange cancel som hidebutton också, dom gör ju samma sak
hideButton.forEach;
