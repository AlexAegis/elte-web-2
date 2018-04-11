window.onload = init;

function $(id) {
    return document.getElementById(id)
}

let currentPlayer
let fields = []
let size
let toWin
let winState

function init() {
    $("startButton").onclick = init
    $('tictactoe').innerHTML = ""

    let sizeFieldVal = $('sizeField').value
    console.log(sizeFieldVal)

    if(sizeFieldVal !== undefined && sizeFieldVal !== "") {
        console.log(sizeFieldVal)
        size = sizeFieldVal
    } else {
        size = 3
        $('sizeField').value = size
    }

    let winFieldVal = $('winField').value
    if(winFieldVal !== undefined && winFieldVal !== "" && winFieldVal <= size) {
        toWin = winFieldVal
    } else {
        toWin = 3
        $('winField').value = toWin
    }

    currentPlayer = 1
    winState = false
    fields = []
    for(let i = 0; i < size; i++) {
        for(let j = 0; j < size; j++) {
            fields.push(new field(new pos(i, j)))
        }
    }
    let table = document.createElement("table")
    let tableBody = document.createElement("tbody")
    table.appendChild(tableBody)

    for(let i = 0; i < size; i++) {
        let tableRow = document.createElement("tr")
        fields.filter(field => field.pos.y === i).forEach(field => {
            let tableData = document.createElement("td")
            field.td = tableData
            tableData.addEventListener("click", placeTick, false)
            tableData.setAttribute("id", "field" + field.pos)
            tableRow.appendChild(tableData)
        })
        tableBody.appendChild(tableRow)
    }
    $('tictactoe').appendChild(table)
}

class field {
    constructor(pos) {
        this.pos = pos
    }
    toString() {
        return "pos: " + this.pos.toString() + ", mark: " + this.mark
    }

}

class pos {
    constructor(x, y) {
        this.x = x
        this.y = y
    }
    toString() {
        return this.x + "," + this.y
    }
}

function placeTick(e) {
    let posArr = e.target.id.split("field")[1].split(",")
    let field = fieldByPos(new pos(posArr[0], posArr[1]))
    if(field.mark === undefined && !winState) {
        field.td.innerHTML = currentPlayerMark()
        field.mark = currentPlayerMark()
        if(checkWin(field)) {
            winState = true
            draw()
        } else {
            currentPlayer = 1 - currentPlayer
        }
    }
}

function draw() {
    fields.forEach(field => {
        if(field.mark !== undefined) {
            if(field.mark === currentPlayerMark()) {
                field.td.className += "filledPlayer2 ";
            } else {
                field.td.className += "filledPlayer2 ";
            }
            directions.forEach(dir => {
                let dst = fieldByPos(destination(field, dir, 1, 1))
                if(dst === undefined || dst.mark === undefined) {
                    field.td.className += dir.classNameFW;
                }
                let dstBack = fieldByPos(destination(field, dir, 1, -1))
                if(dstBack === undefined || dstBack.mark === undefined) {
                    field.td.className += dir.classNameBW;
                }
            })
        }
    })
}

function fieldByPos(posObj) {
    return fields.filter(field => field.pos.toString() === posObj.toString()).pop()
}


function checkWin(fieldClicked) {
    let win = false;
    directions.forEach(dir => {
        let checks = 1;
        let stillPlayer = true
        let i = 1
        while(i < toWin && stillPlayer && !isOutOfBounds(destination(fieldClicked, dir, i, 1))) {
            let field = fields.filter(f => f.pos.toString() === destination(fieldClicked, dir, i, 1).toString()).pop()
            stillPlayer &= (field.mark === currentPlayerMark())
            if(stillPlayer) {
                checks++
            }
            i++
        }
        let j = 1
        stillPlayer = true
        while(j < toWin && stillPlayer && !isOutOfBounds(destination(fieldClicked, dir, j, -1))) {
            let field = fields.filter(f => f.pos.toString() === destination(fieldClicked, dir, j, -1).toString()).pop()
            stillPlayer &= (field.mark === currentPlayerMark())
            if(stillPlayer) {
                checks++
            }
            j++
        }
        win |= checks >= toWin
    })
    return win
}


function destination(field, dir, step, direction) {
    return new pos(field.pos.x + (dir.pos.x * step * direction), field.pos.y + (dir.pos.y * step * direction))
}

function isOutOfBounds(pos) {
    return pos.x < 0 || pos.y < 0 || pos.x > size - 1 || pos.y > size - 1
}

function currentPlayerMark() {
    return currentPlayer === 0 ? "X" : "O"
}

const directions = [
    {
        name: "→",
        classNameFW: "rightBorder ",
        classNameBW: "leftBorder ",
        pos: new pos(1, 0)
    },
    {
        name: "↘",
        classNameFW: "",
        classNameBW: "",
        pos: new pos(1, 1)
    },
    {
        name: "↓",
        classNameFW: "bottomBorder ",
        classNameBW: "topBorder ",
        pos: new pos(0, 1)
    },
    {
        name: "↙",
        classNameFW: "",
        classNameBW: "",
        pos: new pos(-1, 1)
    }
]
