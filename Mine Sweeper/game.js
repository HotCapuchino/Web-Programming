let field = document.querySelector(".general-block_field");
let bombs = [];
let Xvector = [-1, 0, 1, 1, 1, 0, -1, -1];
let Yvector = [-1, -1, -1, 0, 1, 1, 1, 0];
// define game properties
let gameVariables = new function() {
    this.turnNumber = 1;
    this.died = false;
    this.bombs_amount = Math.floor(Math.random() * 10 + 5);
    this.cells_to_unlock = 144 - this.bombs_amount;
    this.flags_remained = this.bombs_amount * 2;
    this.bombs_defused = 0;
    this.setRemainedCells = (value) => {
        this.cells_to_unlock = value;
    };
    this.setRemainedFlags = (value) => {
        this.flags_remained = value;
    }
}
let field_data = new Array(12);
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
            field.appendChild(field_cell);
        }
    }
}
buildField();
let cells = field.children;
// left click on cell
function onFieldCellLeftClick() {
    let clicked_bttn = event.target;
    let position = (clicked_bttn.getAttribute("position")).split(' ');
    if (cells[(+position[0] - 1) * 12 + +position[1] - 1].classList.contains("flag")) {
        alert("You can't go here! Firstly, remove the flag!");
    } else {
        if (gameVariables.turnNumber === 1) {
            bombPositioning(position);
            console.log(field_data);
            fillTheField();
            gameVariables.turnNumber += 1;
            makeMove(position);
            console.log(gameVariables);
        } else {
            makeMove(position);
            console.log(gameVariables);
            isOver();
        }
    }
}
// right click on cell
function onFieldCellRightClick() {
    let clicked_bttn = event.target;
    let position = (clicked_bttn.getAttribute("position")).split(' ');
    if (cells[(+position[0] - 1) * 12 + +position[1] - 1].classList.contains("flag")) {
        cells[(+position[0] - 1) * 12 + +position[1] - 1].classList.remove("flag");
        cells[(+position[0] - 1) * 12 + +position[1] - 1].classList.add("closed-cell");
        gameVariables.setRemainedFlags(gameVariables.flags_remained + 1);
        defusing(position, "remove");
    } else if (!cells[(+position[0] - 1) * 12 + +position[1] - 1].classList.contains("flag") && 
    gameVariables.flags_remained === 0) {
        alert("You've run out of flags! Try to remove at least one flag!");
    } else {
        cells[(+position[0] - 1) * 12 + +position[1] - 1].classList.remove("closed-cell");
        cells[(+position[0] - 1) * 12 + +position[1] - 1].classList.add("flag");
        gameVariables.setRemainedFlags(gameVariables.flags_remained - 1);
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
    let generated_Xs = [];
    let generated_Ys = [];
    for (let i = 0; i < gameVariables.bombs_amount; i++) {
        setTimeout(10);
        while (true) {
            var x = Math.floor(Math.random() * 12);
            var y = Math.floor(Math.random() * 12);
            if (!generated_Xs.includes(x) && !generated_Ys.includes(y) && x !== clickX && y !== clickY) {
                console.log('yes');
                generated_Xs.push(x);
                generated_Ys.push(y);
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
    if (isDead(position)) {
        clicked_cell.classList.remove("closed-cell");
        clicked_cell.classList.add("bomb");
    } else {
        let x = +position[0] - 1;
        let y = +position[1] - 1;
        if (field_data[x][y] !== 0) {
            clicked_cell.classList.remove("closed-cell");
            clicked_cell.classList.add("opened-cell");
            clicked_cell.textContent = field_data[x][y];
            gameVariables.setRemainedCells(gameVariables.cells_to_unlock - 1);
        } else {
            clicked_cell.classList.remove("closed-cell");
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
    let wasFoundBlank = false;
    for (let i = 0; i < 8; i++) {
        let x_offset = x + Xvector[i];
        let y_offset = y + Yvector[i];
        if (x_offset >= 0 && x_offset <= 11 && y_offset >= 0 && y_offset <= 11) {
            if (cells[x_offset * 12 + y_offset].classList.contains("closed-cell")) {
                if (field_data[x_offset][y_offset] === 0) {
                    wasFoundBlank = true;
                    cells[x_offset * 12 + y_offset].classList.remove("closed-cell");
                    cells[x_offset * 12 + y_offset].classList.add("opened-cell");
                    gameVariables.setRemainedCells(gameVariables.cells_to_unlock - 1);
                    openTheCell(x_offset, y_offset);
                } else if (typeof(field_data[x_offset][y_offset]) === 'number') {
                    cells[x_offset * 12 + y_offset].classList.remove("closed-cell");
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
        return true;
    } else {
        return false;
    }
}
// checking if the game's over
function isOver() {
    if (gameVariables.bombs_defused === gameVariables.bombs_amount) {
        printResult('defused');
    } else if (gameVariables.cells_to_unlock === 0) {
        printResult('unlocked');
    } else if (gameVariables.died) {
        printResult('dead');
    }
}
// print the result of game
function printResult(reason) {
    for (const i of field.children) {
        i.removeEventListener('click', onFieldCellLeftClick);
        i.removeEventListener('contextmenu', onFieldCellRightClick);
    }
    if (reason === 'unlocked') {
        alert("Congratulations! You've unlocked all the field cells!");
    } else if (reason === 'defused') {
        alert("Congratulations! You've defused all the bombs!")
    } else if (reason === 'dead') {
        alert("You're dead! Try again!");
    } else if (reason === 'timeisup') {
        alert("I see you're about to be very petient.. Not a good strategy for a life");
    } else {
        alert("Damn, bro, how has this condition even worked?");
    }
}