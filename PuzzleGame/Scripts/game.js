{
/// class Timer
class Timer {

    constructor(timer_options) {
        this.timer = timer_options.timer;
        this.timer.innerHTML = timer_options.time;
        this.seconds = +(timer_options.time.split(":")[1]);
        this.minutes = +(timer_options.time.split(":")[0]);
        this.game = timer_options.game;
    }

/// calculating remaining time
    calculatingTime() {
        this.seconds = +(this.timer.innerHTML.split(":")[1]) - 1 >= 0 ? +(this.timer.innerHTML.split(":")[1]) - 1 : 59;
        this.minutes = this.seconds < 59 ? this.timer.innerHTML.split(":")[0] : this.timer.innerHTML.split(":")[0] - 1;
        if (this.minutes <= -1 && this.seconds === 59) return "stop";
        this.isTimeRunningOut();
        this.seconds = this.seconds >= 10 ? this.seconds : "0" + this.seconds;
        this.timer.innerHTML = this.minutes + ":" + this.seconds;
    }

/// check if it's only one minute left
    isTimeRunningOut() {
        if (this.isTimeRunningOut.called) return;
        if (this.minutes === 0) {
            console.log("timerunning");
            this.timer.classList.remove("enough-time");
            this.timer.classList.add("time-is-running-out");
            this.isTimeRunningOut.called = true;
        }
    }

/// starting countdown
    start() {
        this.intervalID = setInterval(() => {
            // console.log("works!");
            if(this.calculatingTime() === "stop") {
                console.log("Your time is up!");
                this.game.endGame("time");
            } 
        }, 1000);            
    }

/// killing countdown
    stop(trigger) {
        this.end_time = this.timer.innerHTML
        console.log("End time: ", this.end_time);
        clearInterval(this.intervalID);
        this.timer.innerHTML = "0:00";
        if (trigger === "victory") {
            this.timer.classList.remove("enough-time");
            this.timer.classList.remove("time-is-running-out");
            this.timer.classList.add("victory");
        }
    }

}
/// class PuzzleGame 
class PuzzleGame {

    constructor(game_preferrences) {
        this.amount_of_puzzles = game_preferrences.amount_of_puzzles;
        this.time_enabled = game_preferrences.time_enabled;
        this.hints_enabled = game_preferrences.hints_enabled;
        this.img_chosen = game_preferrences.img_chosen;
        this.img_width = game_preferrences.img_width;
        this.img_height = game_preferrences.img_height;
        this.hints_used = 0;
    }

/// master function starts the game
    startGame(desk_with_pieces, desk_with_puzzles) {
        this.desk_with_pieces = desk_with_pieces;
        this.desk_with_puzzles = desk_with_puzzles;
        this.generateField();
        this.shuffleAndLocate();
        this.addListenersToDeskWithPieces();
        this.setTimer();
    }

/// drag and drop
    addListenersToDeskWithPieces() {
        this.desk_with_pieces.addEventListener('mouseover', function() {
            if (event.target.classList.contains("shuffled-tile")) {
                event.target.classList.add("hovered-shuffled-puzzle");
                ///
                function mouseOut() {
                    event.target.classList.remove("hovered-shuffled-puzzle");
                    event.target.removeEventListener('mouseout', mouseOut);
                }
                event.target.addEventListener('mouseout', mouseOut);
            }
        });
        for (const i of this.tiles) {
            i.addEventListener('mousedown', () => {
                // event.target.style.zIndex = 1000;
                moveToOrigin.originPositionX = event.target.style.left;
                moveToOrigin.originPositionY = event.target.style.top;
                document.body.append(event.target);
                i.setAttribute("drag", "");
                moveTo.bind(this)();
            });
            i.addEventListener('mouseup', () => {
                i.removeAttribute("drag");
                Drop.bind(this)();
                if (this.cells_remained === 0) {
                    this.endGame("victory");
                }
            }); 
            i.addEventListener('mousemove', moveTo.bind(this));
        }

/// hints
        if (this.hints_enabled == 1) {
            function giveHint() {
                this.hints_used++;
                event.preventDefault();
                let target_cell = undefined;
                for (const elem of document.querySelectorAll(".tile")) {
                    if (elem.getAttribute("position") === event.target.getAttribute("position")) {
                        target_cell = elem;
                    }
                }
                // target_cell.style.transform = "scale(1.2)";
                target_cell.style.opacity = "0.75";
                setTimeout(function() { 
                    // target_cell.style.transform = "none"; 
                    target_cell.style.opacity = "1";
                }, 250);
            }
            for (const i of this.tiles) {
                i.addEventListener('contextmenu', giveHint.bind(this));
            }
        }

/// moving tile to particular place
        function moveTo() {
            if (event.target.hasAttribute("drag")){
                event.target.style.left = (event.pageX - this.tile_width / 2) + "px";
                event.target.style.top = (event.pageY - this.tile_height / 2) + "px";
            }
        }

/// moving tile to it original place
        function moveToOrigin() {
            this.desk_with_pieces.append(event.target);
            event.target.style.left = moveToOrigin.originPositionX;
            event.target.style.top = moveToOrigin.originPositionY;
        }

/// dropping the tile
        function Drop() {
            let target_cell = undefined;
            for (const elem of document.querySelectorAll(".tile")) {
                if (elem.getAttribute("position") === event.target.getAttribute("position")) {
                    target_cell = elem;
                }
            }
            // console.log(target_cell.getBoundingClientRect().x, event.target.getBoundingClientRect().x,
            //             target_cell.getBoundingClientRect().y, event.target.getBoundingClientRect().y);
            if (Math.abs(target_cell.getBoundingClientRect().x - event.target.getBoundingClientRect().x) < this.tile_width / 4 
                && Math.abs(target_cell.getBoundingClientRect().y - event.target.getBoundingClientRect().y) < this.tile_height / 4) {
                event.target.classList.add("visibility");
                target_cell.classList.remove("closed");
                target_cell.classList.add("open");
                document.body.removeChild(event.target);
                this.cells_remained--;
                console.log(this.cells_remained);
            } else {
                moveToOrigin.bind(this)();
            }
        }
    }

/// function that ends the game
    endGame(trigger) {
        if (this.time_enabled == 1) this.timer.stop(trigger);
        if (trigger === "time") {
            let puzzles_on_the_grid = this.desk_with_puzzles.children;
            for (const elem of this.tiles) {
                setTimeout(() => {
                    let position = +elem.getAttribute("position").split(" ")[0] * this.columns + +elem.getAttribute("position").split(" ")[1];
                    puzzles_on_the_grid[position].classList.remove("closed");
                    puzzles_on_the_grid[position].classList.add("open");
                    this.desk_with_pieces.removeChild(elem);
                }, 250);
            }
        }
        this.showResults(trigger);
        // delete this;
    }

/// clearing the field for retry
    clear() {
        this.desk_with_puzzles.innerHTML = null;
        document.querySelector(".results-wrapper").classList.add("visibility");
    }

/// setting timer
    setTimer() {
        if (this.time_enabled == 1) {
            this.timer = new Timer({
                timer: document.querySelector(".timer"),
                time: (this.amount_of_puzzles * 10 / 60).toFixed(0) + ":" + (this.amount_of_puzzles * 10 % 60),
                // time: "0:10",
                game: this
            });
            let result = this.timer.start();
            if (result === "game_over") { this.endGame(); }
        } else {
            document.querySelector(".timer").style.height = "50px";
        }
    }

/// function that shows results of the game
    showResults(trigger) {
        let results_block = document.querySelector(".results-wrapper");
        results_block.classList.remove("visibility");
        let score = 0;
        if (this.hints_enabled == 1) {
            results_block.querySelector(".hints-were-used").classList.remove("visibility");
            results_block.querySelector(".hints-were-used").innerHTML += this.hints_used;
            score += (this.amount_of_puzzles - this.hints_used) * 100;
        }
        score += this.amount_of_puzzles * 70;
        if (this.time_enabled == 1) {
            results_block.querySelector(".time-spent").classList.remove("visibility");
            let minutes_spent = (this.amount_of_puzzles * 10 / 60).toFixed(0) - +(this.timer.end_time.split(":")[0]);
            console.log((this.amount_of_puzzles * 10 / 60).toFixed(0), (this.timer.end_time.split(":")[0]));
            let seconds_spent = 0;
            if (this.amount_of_puzzles * 10 % 60 - +this.timer.end_time.split(":")[1] >= 0) {
                seconds_spent = this.amount_of_puzzles * 10 % 60 - +(this.timer.end_time.split(":")[1]);
            } else {
                minutes_spent++;
                seconds_spent = 60 - +(this.timer.end_time.split(":")[1]) + this.amount_of_puzzles * 10 % 60;
            }
            results_block.querySelector(".time-spent").innerHTML += 
            minutes_spent + " минут, " + seconds_spent + " секунд";
            score += +this.timer.end_time.split(":")[0] * 60 + +this.timer.end_time.split(":")[1];
        }
        if (trigger === "victory") {
            results_block.querySelector(".result-title").innerHTML = "Победа!";
            results_block.querySelector(".result-title").classList.add("victory");
            results_block.querySelector(".score").innerHTML += score;
        } else {
            results_block.querySelector(".result-title").innerHTML = "Поражение!";
            results_block.querySelector(".result-title").classList.add("time-is-running-out");
            results_block.querySelector(".score").innerHTML += 0;
        }
    }

/// generating field with puzzles
    generateField() {
        let min_columns = 5;
        let min_rows = 2;
        let max_columns = 15;
        let max_rows = 10;
        this.rows = 0;
        this.columns = 0;
        // calculating optimal amount of rows and columns
        function decomposition() {
            outer: while (true) {
                for (let i = max_rows; i >= min_rows; i--) {
                    if (this.amount_of_puzzles % i === 0 && 
                        this.amount_of_puzzles / i <= max_columns && 
                        this.amount_of_puzzles / i >= min_columns) { 
                        this.rows = i;
                        this.columns = this.amount_of_puzzles / i;
                        break outer;
                    }
                }
                this.amount_of_puzzles++;
            };
        }
        decomposition.bind(this)();
        this.cells_opened = Math.round(this.amount_of_puzzles * 0.1);
        this.cells_remained = this.amount_of_puzzles - this.cells_opened;
        console.log(this.cells_remained);
        // calculating the size of the tile
        this.tile_width = this.img_width / this.columns;
        this.tile_height = this.img_height / this.rows;
        let template_cols = "";
        let template_rows = "";
        for (let i = 0; i < this.columns; i++) {
            template_cols += this.tile_width + "px ";
        }
        for (let i = 0; i < this.rows; i++) {
            template_rows += this.tile_height + "px ";
        }
        this.desk_with_puzzles.style.gridTemplateColumns = template_cols;
        this.desk_with_puzzles.style.gridTemplateRows = template_rows;
        let open_cells_remained = this.cells_opened;
        // building grid with puzzles
        for (let i = 0; i < this.rows; i++) {
            for (let j = 0; j < this.columns; j++) {
                let tile = document.createElement("div");
                tile.setAttribute("position", `${i} ${j}`);
                tile.classList.add("tile");
                tile.classList.add("closed");
                tile.style.width = this.tile_width;
                tile.style.height = this.tile_height;
                this.desk_with_puzzles.appendChild(tile);
            }
        }
        // opening random cells just to make it's easy for player
        while (open_cells_remained > 0) {
            let random_x = Math.round(Math.random() * this.columns);
            let random_y = Math.round(Math.random() * this.rows);
            for (const elem of document.querySelectorAll(".tile")) {
                if (elem.getAttribute("position") == `${random_y} ${random_x}` 
                && !elem.classList.contains("open")) { 
                    elem.classList.remove("closed");
                    elem.classList.add("open");
                    open_cells_remained--;
                }
            }
        }
    }

/// shuffle and locating tiles on the opposite field
    shuffleAndLocate() {
        let locations = [];
        // generate random position
        function positioning(...args) {
            while (true) {
                let left = Math.random() * (args[0] - 50 - args[2]) + 50;
                let top = Math.random() * (args[1] - 50 - args[3]) + 50;
                let passed = true;
                for (const elem of locations) {
                    if (Math.abs(elem.left - left) < args[2] / 2 &&
                        Math.abs(elem.top - top) < args[3] / 2) {
                        passed = false;
                        break;
                    }
                }
                if (passed) {
                    let obj = {left: left, top: top};
                    locations.push(obj);
                    return obj;
                }
            }
        }
        let start_left = Math.random() * (this.desk_with_pieces.clientWidth  - 50 - this.tile_width) + 50;
        let start_top = Math.random() * (this.desk_with_pieces.clientHeight - 50 - this.tile_height) + 50;
        locations.push({ left: start_left, top: start_top });
        this.tiles = [];
        let puzzles_on_the_grid = this.desk_with_puzzles.children;
        // adding tiles
        for (let i = 0; i < this.rows; i++) {
            for (let j = 0; j < this.columns; j++) {
                if (!puzzles_on_the_grid[i * this.columns + j].classList.contains("open")) {
                    let shuffled_tile = document.createElement("div");
                    shuffled_tile.style.width = this.tile_width + "px";
                    shuffled_tile.style.height = this.tile_height + "px";
                    shuffled_tile.classList.add("shuffled-tile");
                    shuffled_tile.setAttribute("position", `${i} ${j}`);
                    //
                    let obj = positioning(this.desk_with_pieces.clientWidth, this.desk_with_pieces.clientHeight, this.tile_width, this.tile_height);
                    shuffled_tile.style.left = obj.left + "px";
                    shuffled_tile.style.top = obj.top + "px";
                    shuffled_tile.style.backgroundSize = `${this.img_width}px ${this.img_height}px`;
                    shuffled_tile.style.backgroundPosition = `${-(this.tile_width * (j))}px ${-(this.tile_height * (i))}px`;
                    shuffled_tile.style.backgroundImage = `url(../res/${+this.img_chosen + 1}.jpg)`;
                    this.tiles.push(shuffled_tile);
                    this.desk_with_pieces.appendChild(shuffled_tile);
                }
            }
        }
    }

};
/// start of the block
let puzzle_image = document.querySelector(".desk_with_puzzle-image");
let real_image_width = sessionStorage.getItem('realWidth');
let real_image_height = sessionStorage.getItem('realHeight');
console.log(real_image_width, real_image_height);
let img_resize_width = real_image_width;
let img_resize_height = real_image_height;
let retry_button = document.querySelector(".retry-button");
retry_button.addEventListener('click', () => {

    game.clear();
    game = new PuzzleGame({
        amount_of_puzzles: sessionStorage.getItem('amount'),
        time_enabled: sessionStorage.getItem('timeLimited'),
        hints_enabled: sessionStorage.getItem('enableHints'),
        img_chosen: sessionStorage.getItem('chosenImage'),
        img_width: img_resize_width,
        img_height: img_resize_height
    });
    game.startGame(document.querySelector(".desk_with_pieces"),
                document.querySelector(".desk_with_puzzle-grid"));
})
// resizing image according to one of its dimensions
function resizeImage() {
    if (+real_image_width > 900) {
        img_resize_width = 900;
        img_resize_height = real_image_height * 900 / real_image_width;
        puzzle_image.style.backgroundSize = `900px ${img_resize_height}px`;
    } else if (+real_image_height > 700) {
        img_resize_height = 700;
        img_resize_width = real_image_width * 700 / real_image_height;
        puzzle_image.style.backgroundSize = `${img_resize_width}px, 700px`;
    }
}
resizeImage();
// creating game
puzzle_image.style.backgroundImage = `url(../res/${+sessionStorage.getItem('chosenImage') + 1}.jpg)`;
let game = new PuzzleGame({
    amount_of_puzzles: sessionStorage.getItem('amount'),
    time_enabled: sessionStorage.getItem('timeLimited'),
    hints_enabled: sessionStorage.getItem('enableHints'),
    img_chosen: sessionStorage.getItem('chosenImage'),
    img_width: img_resize_width,
    img_height: img_resize_height
});
// starting game
game.startGame(document.querySelector(".desk_with_pieces"),
                document.querySelector(".desk_with_puzzle-grid"));
/// end of the block
}