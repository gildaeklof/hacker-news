const votebutton = document.querySelector(".votebutton");

function toggleUpvote() {
  if (votebutton.innerHTML === "Upvote") {
  } else {
    votebutton.innerHTML = "Unvote";
  }
}
