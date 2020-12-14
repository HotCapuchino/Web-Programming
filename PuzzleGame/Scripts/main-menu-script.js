{
let chosen_img = +sessionStorage.getItem('chosenImage');
console.log(chosen_img);
let real_width = 0;
let real_height = 0;
let header_images = document.querySelectorAll(".header-img");
for (let i = 0; i < header_images.length; i++) {
    try {
        header_images[i].style.backgroundImage = `url(../res/${i + 1}.jpg)`;
        header_images[i].setAttribute("number", i);
        header_images[i].classList.add("grayscale");
    } catch (e) {}
}
paintChosen();
///
function paintChosen() {
    header_images[chosen_img].classList.remove("grayscale");
}
/// 
let list_with_images = document.querySelector(".image_list");
let chosen_image_block = document.querySelector(".chosen-image");
chosen_image_block.setAttribute("src" ,`../res/${chosen_img + 1}.jpg`);
chosen_image_block.onload = function() {
    real_width = chosen_image_block.naturalWidth;
    real_height = chosen_image_block.naturalHeight;
    console.log("real dimensions", real_width, real_height);
}
list_with_images.addEventListener('click', () => {
    if (event.target.classList.contains("header-img")) {
        chosen_img = event.target.getAttribute("number"); 
        sessionStorage.setItem("chosenImage", chosen_img); 
        chosen_image_block.setAttribute("src" , event.target.style.backgroundImage.slice(5, -2));
        real_width = chosen_image_block.naturalWidth;
        real_height = chosen_image_block.naturalHeight; 
    }
});
/// focus/unfocus elem of the header
list_with_images.addEventListener('mouseover', () => {
    if (event.target.classList.contains("header-img")) {
        // header_images.forEach(value, () => { value.classList.add("grayscale"); });
        for (let img of header_images) {
            img.classList.add("grayscale");
        }
        event.target.classList.remove("grayscale");
    }
});
list_with_images.addEventListener('mouseout', () => {
    if (event.target.classList.contains("header-img")) {
        event.target.classList.add("grayscale");
        paintChosen();
    }
});
/// enabling/disabling hints
let enable_hints = document.querySelector(".enable-hints");
if (sessionStorage.getItem("enableHints")) {
    +sessionStorage.getItem("enableHints")  === 1 ? enable_hints.setAttribute("checked", "") : enable_hints.removeAttribute("checked");
} else {
    enable_hints.setAttribute("checked", "");
    sessionStorage.setItem("enableHints", 1);
}
enable_hints.addEventListener('input', () => {
    if (enable_hints.hasAttribute("checked")) {
        enable_hints.removeAttribute("checked");
        sessionStorage.setItem("enableHints", 0);
    } else {
        enable_hints.setAttribute("checked", "");
        sessionStorage.setItem("enableHints", 1);
    }
});
/// enabling/disabling countdown
let time_limit = document.querySelector(".enable-time-clock");
if (sessionStorage.getItem("timeLimited")) {
    +sessionStorage.getItem("timeLimited") === 1 ? time_limit.setAttribute("checked", "") : time_limit.removeAttribute("checked");
} else {
    time_limit.setAttribute("checked", "");
    sessionStorage.setItem("timeLimited", 1);
}
time_limit.addEventListener('input', () => {
    if (time_limit.hasAttribute("checked")) {
        time_limit.removeAttribute("checked");
        sessionStorage.setItem("timeLimited", 0);
    } else {
        time_limit.setAttribute("checked", "");
        sessionStorage.setItem("timeLimited", 1);
    }
});
/// setting and saving the value of the range
let amount_of_puzzles_range = document.querySelector("input[type=range]");
let amount_of_puzzles_div = document.querySelector(".puzzles-amount");
if (sessionStorage.getItem('amount')) {
    amount_of_puzzles_div.innerHTML = +sessionStorage.getItem('amount');
    amount_of_puzzles_range.value = +sessionStorage.getItem('amount');
} else {
    amount_of_puzzles_div.innerHTML = 50;
    amount_of_puzzles_range.value = 50;
    sessionStorage.setItem('amount', 50);
}
amount_of_puzzles_range.addEventListener('input', countAmount);
function countAmount() {
    amount_of_puzzles_div.innerHTML = amount_of_puzzles_range.value;
    sessionStorage.setItem('amount', amount_of_puzzles_range.value);
}
countAmount();
/// start game button
let start_game_bttn = document.querySelector(".start-game-button");
start_game_bttn.addEventListener('click', () => {
    sessionStorage.setItem('chosenImage', chosen_img);
    sessionStorage.setItem('realWidth', real_width);
    sessionStorage.setItem('realHeight', real_height);
});
}