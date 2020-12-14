{
/// start of the block
let slider_images = document.querySelectorAll(".slider-image");
let slider = document.querySelector(".slider");
let slider_wrapper = document.querySelector(".slider-wrapper");
let counter = 0;
let img_size;
let next_buttn = document.querySelector(".next");
let prev_buttn = document.querySelector(".prev");
/// slider next
next_buttn.addEventListener('click', function() {
    if (counter === 5) {
        return;
    } 
    img_size = slider_images[counter].clientWidth;
    counter++;
    slider.style.transform = "translateX(" + (-img_size + parseInt(slider.style.transform.slice(11))) + "px)";
    slider_wrapper.style.width = slider_images[counter].clientWidth + "px";
});
/// slider previous
prev_buttn.addEventListener('click', function() {
    if (counter === 0) {
        return;
    }
    counter--;
    img_size = slider_images[counter].clientWidth;
    slider.style.transform = "translateX(" + (img_size + parseInt(slider.style.transform.slice(11))) + "px)";
    slider_wrapper.style.width = img_size + "px";
});
/// choose picture button
let start_game_button = document.querySelector(".choose-image-button");
start_game_button.addEventListener('click', function() {
    sessionStorage.setItem('chosenImage', counter);
});
/// end of the block
}