
var stars = document.querySelector(".rating_stars").querySelectorAll("input");
stars.forEach((star) => {
    star.addEventListener("change", feedback);
});

function feedback() {
    document.querySelector(".feedback").style.maxHeight = "1000px";
    document.querySelector(".feedback_button").style.display = "inline-block";
}

const closeButton = document.querySelector(".close_icon");
if (closeButton) {
    closeButton.addEventListener("click", () => {
        document.querySelector(".order-message-container").style.display = "none";
    });
}
