let start_time = null;
let field = document.querySelector(".general-block_field");
let bombs = [];
let Xvector = [-1, 0, 1, 1, 1, 0, -1, -1];
let Yvector = [-1, -1, -1, 0, 1, 1, 1, 0];
// define game properties
let gameVariables = new function() {
    this.turnNumber = 1;
    this.died = false;
    this.bombs_amount = Math.floor(Math.random() * 10) + 10;
    this.cells_to_unlock = 144 - this.bombs_amount;
    this.flags_remained = this.bombs_amount * 2;
    this.bombs_defused = 0;
    this.setRemainedCells = (value) => {
        this.cells_to_unlock = value;
    };
    this.setRemainedFlags = (value) => {
        this.flags_remained = value;
    }
    this.currentCell = '1 1';
}
let field_data = new Array(12);
// console.log(gameVariables.bombs_amount);
// dynamically generate field
function buildField() {
    for (let i = 0; i < 12; i++) {
        field_data[i] = new Array(12);
        for (let j = 0; j < 12; j++) {
            field_data[i][j] = 0;
            let field_cell = document.createElement("div");
            field_cell.classList.add("general-block_field-cell");
            field_cell.classList.add("closed-cell");
            field_cell.setAttribute("position", `${i + 1} ${j + 1}`);
            field_cell.addEventListener('click', onFieldCellLeftClick);
            field_cell.addEventListener('contextmenu', onFieldCellRightClick);
            field_cell.addEventListener('mouseover', onCellFocused);
            field_cell.addEventListener('mouseout', onCellUnFocused);
            field.appendChild(field_cell);
        }
    }
}
buildField();
let cells = field.children;
console.log(cells);
// left click on cell or keyboard Space or Enter
function onFieldCellLeftClick(reason) {
    if (typeof(reason) === 'object') {
        let clicked_bttn = event.target;
        var position = (clicked_bttn.getAttribute("position")).split(' ');
    } else if (typeof(reason) === 'string') {
        var position = reason.split(' ');
    }
    if (cells[(+position[0] - 1) * 12 + +position[1] - 1].classList.contains("flag")) {
        alert("You can't go here! Firstly, remove the flag!");
    } else {
        if (gameVariables.turnNumber === 1) {
            bombPositioning(position);
            console.log(field_data);
            fillTheField();
            gameVariables.turnNumber += 1;
            makeMove(position);
            // console.log(gameVariables);
            start_time = performance.now();
        } else {
            makeMove(position);
            // console.log(gameVariables);
            isOver();
        }
    }
}
// right click on cell or keyboard Space-Ctrl or Enter-Ctrl
function onFieldCellRightClick(reason) {
    if (typeof(reason) === 'object') {
        let clicked_bttn = event.target;
        var position = (clicked_bttn.getAttribute("position")).split(' ');
    } else if (typeof(reason) === 'string') {
        console.log("Functions was called because of keyboard action!");
        return;
    }
    if (cells[(+position[0] - 1) * 12 + +position[1] - 1].classList.contains("flag")) {
        cells[(+position[0] - 1) * 12 + +position[1] - 1].classList.remove("flag");
        cells[(+position[0] - 1) * 12 + +position[1] - 1].classList.add("closed-cell");
        gameVariables.setRemainedFlags(gameVariables.flags_remained + 1);
        showRemainedFlags(gameVariables.flags_remained);
        defusing(position, "remove");
    } else if (!cells[(+position[0] - 1) * 12 + +position[1] - 1].classList.contains("flag") && 
    gameVariables.flags_remained === 0) {
        alert("You've run out of flags! Try to remove at least one flag!");
    } else {
        cells[(+position[0] - 1) * 12 + +position[1] - 1].classList.remove("closed-cell");
        cells[(+position[0] - 1) * 12 + +position[1] - 1].classList.add("flag");
        gameVariables.setRemainedFlags(gameVariables.flags_remained - 1);
        showRemainedFlags(gameVariables.flags_remained);
        defusing(position, "set");
        isOver();
    }
}
// prevening bubbling  default contextmenu
field.addEventListener('contextmenu', function(event) {
    event.preventDefault();
});
// locating bombs
function bombPositioning(position) {
    let clickX = +position[0] - 1;
    let clickY = +position[1] - 1;
    let generated_pairs = [];
    for (let i = 0; i < gameVariables.bombs_amount; i++) {
        while (true) {
            var x = Math.floor(Math.random() * 12);
            var y = Math.floor(Math.random() * 12);
            if (!generated_pairs.includes([x, y]) && x !== clickX && y !== clickY) {
                generated_pairs.push([x, y]);
                console.log(`${x}, ${y}`); 
                break;
            }
        }
        field_data[x][y] = 'x';
        let bomb = new function() {
            this.x = x;
            this.y = y;
            this.active = true;
            this.setActive = (value) => {
                this.active = !!value;
            }
        };
        bombs.push(bomb);
    }
}
// filling in the field data
function fillTheField() {
    for (let i = 0; i < 12; i++) {
        for (let j = 0; j < 12; j++) {
            if (field_data[i][j] === 'x') {
                for (let k = 0; k < 8; k++) {
                    let x_offset = i + Xvector[k];
                    let y_offset = j + Yvector[k];
                    if (x_offset >= 0 && x_offset <= 11 && y_offset >= 0 
                        && y_offset <= 11 && field_data[x_offset][y_offset] !== 'x') { 
                        field_data[x_offset][y_offset] += 1;
                    }
                }
            }
        }
    }
}   
// defusing function 
function defusing(position, action) {
    let x = +position[0] - 1;
    let y = +position[1] - 1;
    if (action === 'set') {
        for (let i = 0; i < bombs.length; i++) {
            if (x === bombs[i].x && y === bombs[i].y && bombs[i].active) {
                bombs[i].setActive(false);
                gameVariables.bombs_defused += 1;
                console.log(bombs[i], gameVariables);
                break;
            }
        }
    } else if (action === 'remove') {
        for (let i = 0; i < bombs.length; i++) {
            if (x === bombs[i].x && y === bombs[i].y && !bombs[i].active) {
                bombs[i].setActive(true);
                gameVariables.bombs_defused -= 1;
                console.log(bombs[i], gameVariables);
                break;
            }
        }
    }
}
// making move
function makeMove(position) {
    let clicked_cell = cells[(+position[0] - 1) * 12 + +position[1] - 1];
    clicked_cell.removeEventListener('click', onFieldCellLeftClick);
    clicked_cell.removeEventListener('contextmenu', onFieldCellRightClick);
    clicked_cell.removeEventListener('mouseover', onCellFocused);
    clicked_cell.removeEventListener('mouseout', onCellUnFocused);
    if (isDead(position)) {
        for (const bomb of bombs) {
            cells[bomb.x * 12 + bomb.y].classList.remove("closed-cell");
            cells[bomb.x * 12 + bomb.y].classList.remove("checked-cell");
            cells[bomb.x * 12 + bomb.y].classList.add("bomb");
        }
    } else {
        let x = +position[0] - 1;
        let y = +position[1] - 1;
        if (field_data[x][y] !== 0) {
            clicked_cell.classList.remove("closed-cell");
            clicked_cell.classList.remove("checked-cell");
            clicked_cell.classList.add("opened-cell");
            clicked_cell.textContent = field_data[x][y];
            gameVariables.setRemainedCells(gameVariables.cells_to_unlock - 1);
        } else {
            clicked_cell.classList.remove("closed-cell");
            clicked_cell.classList.remove("checked-cell");
            clicked_cell.classList.add("opened-cell");
            gameVariables.setRemainedCells(gameVariables.cells_to_unlock - 1);
            openTheCell(x, y);
        }
    }
}
// opening the cell
function openTheCell(x, y) {
    let blank_cell = cells[x * 12 + y];
    blank_cell.removeEventListener('click', onFieldCellLeftClick);
    blank_cell.removeEventListener('contextmenu', onFieldCellRightClick);
    blank_cell.removeEventListener('mouseover', onCellFocused);
    blank_cell.removeEventListener('mouseout', onCellUnFocused);
    let wasFoundBlank = false;
    for (let i = 0; i < 8; i++) {
        let x_offset = x + Xvector[i];
        let y_offset = y + Yvector[i];
        if (x_offset >= 0 && x_offset <= 11 && y_offset >= 0 && y_offset <= 11) {
            if (cells[x_offset * 12 + y_offset].classList.contains("closed-cell")) {
                if (field_data[x_offset][y_offset] === 0) {
                    wasFoundBlank = true;
                    cells[x_offset * 12 + y_offset].classList.remove("closed-cell");
                    cells[x_offset * 12 + y_offset].classList.remove("checked-cell");
                    cells[x_offset * 12 + y_offset].classList.add("opened-cell");
                    gameVariables.setRemainedCells(gameVariables.cells_to_unlock - 1);
                    openTheCell(x_offset, y_offset);
                } else if (typeof(field_data[x_offset][y_offset]) === 'number') {
                    cells[x_offset * 12 + y_offset].classList.remove("closed-cell");
                    cells[x_offset * 12 + y_offset].classList.remove("checked-cell");
                    cells[x_offset * 12 + y_offset].classList.add("opened-cell");
                    gameVariables.setRemainedCells(gameVariables.cells_to_unlock - 1);
                    cells[x_offset * 12 + y_offset].textContent = field_data[x_offset][y_offset];
                }
            }
        }
    }
    if (wasFoundBlank) {
        return true;
    }
}
// checking the death 
function isDead(position) {
    if (field_data[+position[0] - 1][+position[1] - 1] === 'x') {
        gameVariables.died = true;
        for (const i of cells) {
            i.removeEventListener('click', onFieldCellLeftClick);
            i.removeEventListener('contextmenu', onFieldCellRightClick);
            i.removeEventListener('mouseover', onCellFocused);
            i.removeEventListener('mouseout', onCellUnFocused);
        }
        return true;
    } else {
        return false;
    }
}
// checking if the game's over
function isOver() {
    if (gameVariables.bombs_defused === gameVariables.bombs_amount) {
        printResult('defused', start_time);
    } else if (gameVariables.cells_to_unlock === 0) {
        printResult('unlocked', start_time);
    } else if (gameVariables.died) {
        printResult('dead', start_time);
    }
}
onCellFocused(gameVariables.currentCell);
/// What about the case you don't have a mouse, but have 
/// a strong desire to play Minesweeper? 
/// Keyboard game functions
window.addEventListener('keydown', trackPressedButtons);
window.addEventListener('keyup', onKeyboardPress);
const controller = {
    13: {pressed: false},
    32: {pressed: false},
    17: {pressed: false},
    40: {pressed: false},
    39: {pressed: false},
    38: {pressed: false},
    37: {pressed: false}
}
function trackPressedButtons() {
    for (const key in controller) {
        if (event.which == key) {
            controller[key].pressed = true;
        }
        console.log(key);
        console.log(controller[key]);
    }
    console.log("----------");
}
function onKeyboardPress() {
    let position = gameVariables.currentCell.split(' ');
    if (controller[17].pressed === true && controller[13].pressed === true 
        || controller[17].pressed === true && controller[32].pressed === true) {
        onFieldCellRightClick(gameVariables.currentCell);    
    } else if (controller[13].pressed === true || controller[32].pressed === true) {
        onFieldCellLeftClick(gameVariables.currentCell);
    } else if (controller[40].pressed === true) {
        markCell(position, "40");
    } else if (controller[39].pressed === true) {
        markCell(position, "39");
    } else if (controller[38].pressed === true) {
        markCell(position, "38");
    } else if (controller[37].pressed === true) {
        markCell(position, "37");
    }
    for (const key in controller) {
        if (event.which == key) {
            controller[key].pressed = false;
        }
        console.log(key);
        console.log(controller[key]);
    }
    console.log("^^^^^^^^^^^^^^^^");
}
// calculate where to go an go
function markCell(position, code) {
    switch(code) {
        case "40":
            position[0] = String(+position[0] + 1);
        break;
        case "39":
            position[1] = String(+position[1] + 1);
        break;
        case "38":
            position[0] = String(+position[0] - 1);
        break;
        case "37":
            position[1] = String(+position[1] - 1);
        break;
        }
    let currentCell = position[0] + ' ' + position[1];
    if (isCellExist(currentCell)) {
        onCellUnFocused(gameVariables.currentCell);
        gameVariables.currentCell = currentCell;
        onCellFocused(currentCell);
    }
}
// focus cell
function onCellFocused(reason) {
    if (typeof(reason) === 'object') {
        for (const i of cells) {
            i.classList.remove('checked-cell');
        }
        event.target.classList.add("checked-cell");
        gameVariables.currentCell = event.target.getAttribute("position");
    } else if (typeof(reason) === 'string') {
        for (const i of cells) {
            i.classList.remove('checked-cell');
        }
        let position = reason.split(' ');
        cells[(+position[0] - 1) * 12 + +position[1] - 1].classList.add("checked-cell");
    }
}
// unfocus cell
function onCellUnFocused(reason) {
    if (typeof(reason) === 'object') {
        if (event.relatedTarget.classList.contains("general-block_field-cell")) {
            event.target.classList.remove("checked-cell");
        } else {
            gameVariables.currentCell = event.target.getAttribute("position");
        }
    } else if (typeof(reason) === 'string') {
        let position = reason.split(' ');
        cells[(+position[0] - 1) * 12 + +position[1] - 1].classList.remove("checked-cell");
    }
}
// check if such cell exists
function isCellExist(position) {
    let possiblePosition = position.split(' ');
    if (+possiblePosition[0] < 1 || +possiblePosition[0] > 12 || 
        +possiblePosition[1] < 1 || +possiblePosition[1] > 12) {
            return false;
        }
    return true;
}