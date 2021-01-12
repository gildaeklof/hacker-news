"use strict";

const upvoteForms = document.querySelectorAll(".upvote");

upvoteForms.forEach((upvoteForm) => {
  upvoteForm.addEventListener("submit", (event) => {
    event.preventDefault();

    const formData = new FormData(upvoteForm);

    fetch("/app/posts/upvote.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => {
        return response.json();
      })
      .then((json) => {
        const upvoteButton = event.target.querySelector(".upvote-button");
        const upvoteStatus = json.status;

        if (upvoteStatus === "unvote") {
          upvoteButton.style.backgroundColor = "grey";
        } else {
          upvoteButton.style.backgroundColor = "cornflowerblue";
        }

        const voteCounts = document.querySelectorAll(".vote-number");
        voteCounts.forEach((voteCount) => {
          if (upvoteButton.dataset.id === voteCount.dataset.id) {
            voteCount.textContent = json.voteCount;
          }
        });
      });
  });
});
