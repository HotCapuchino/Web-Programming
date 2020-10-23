let flagRemainedMssg = document.querySelector(".flags-remained-message-block");
let flagsAmountField = document.querySelector(".flags-remained-message-block_flags-amount");
let printResultsBlock = document.querySelector(".results-block");
// show remaining flags
async function showRemainedFlags(amount) {
    flagsAmountField.textContent = amount;
    flagRemainedMssg.classList.remove("none");
    await new Promise(resolve => setTimeout(resolve, 1000));
    flagRemainedMssg.classList.add("none");
}
// print results of the game
function printResult(reason, time) {
    end_time = performance.now();
    for (const i of cells) {
        i.removeEventListener('click', onFieldCellLeftClick);
        i.removeEventListener('contextmenu', onFieldCellRightClick);
    }
    let resultsField = document.querySelector(".results-block_result");
    let cells_unlocked = document.querySelector(".game-stats_cells-unlocked");
    let bombs_defused = document.querySelector(".game-stats_bomb-defused");
    let time_spent = document.querySelector(".game-stats_time");
    let reset_bttn = document.querySelector(".reset-bttn");
    let exit_bttn = document.querySelector(".results-block_exit");
    if (reason === 'unlocked') {
        resultsField.textContent = "Вы выиграли, открыв все ячейки!";
    } else if (reason === 'defused') {
        resultsField.textContent = "Вы выиграли, разминировав все бомбы!";
    } else if (reason === 'dead') {
        resultsField.textContent = "Вы проиграли, подорвашись на мине...";
    } else if (reason === 'timeisup') {
        alert("I see you're about to be very petient.. Not a good strategy for a life");
    } else {
        alert("Damn, bro, how has this condition even worked?");
    }
    cells_unlocked.textContent += 144 - gameVariables.bombs_amount - gameVariables.cells_to_unlock;
    bombs_defused.textContent += gameVariables.bombs_defused;
    time_spent.textContent += parseInt((end_time - time) / 60000) 
    + " минут " + parseInt((end_time - time) / 1000 % 60) + " секунд";
    reset_bttn.addEventListener('click', gameReset);
    exit_bttn.addEventListener('click', function() {
        printResultsBlock.classList.add("none"); 
    });
    printResultsBlock.classList.remove("none");
}
// game reset
function gameReset() {
    location.reload();
}
// on resizing window
window.onresize = resize;
window.onload = resize;
function resize() {
    let window_width = window.innerWidth;
    console.log(window_width);
    flagRemainedMssg.style.left = (Number(window_width / 2 - 100)) + "px";
    let result_block_width = printResultsBlock.offsetWidth;
    printResultsBlock.style.left = (Number(window_width / 2 - 200)) + "px";
}
