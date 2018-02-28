window.onload = init;

function $(id) {
    return document.getElementById(id)
}

let currentPlayer
let fields = []
const size = 3
const toWin = 3

function init() {
    currentPlayer = 1
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
        fields.filter(field => field.pos.x === i).forEach(field => {
            let tableData = document.createElement("td")
            field.td = tableData
            tableData.addEventListener('click', placeTick, false)
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
        return this.pos + ", " + this.td.innerHTML
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
    let posObj = new pos(posArr[0], posArr[1])
    let field = fields.filter(field => field.pos.toString() === posObj.toString()).pop()//.forEach(field => console.log("FUCK ME" + field.toString()))
    field.td.innerHTML = currentPlayer === 0 ? "X" : "O"
    currentPlayer = 1 - currentPlayer
    checkWin(field)
}

function checkWin(field) {
    console.log(field)
    directions.forEach(dir => {
        let stillPlayer = true

        for(let i = 0; i < toWin && stillPlayer; i++) {
            let currPos = new pos(field.pos.x + dir.pos.x * i, field.pos.y + dir.pos.y * i)
            let field = fields.filter(field => field.pos.toString() === currPos.toString()).pop()

            console.log(field)
        }

    })
}

const directions = [
    {
        name: "LtoR",
        pos: new pos(-1, 0)
    },
    {
        name: "LUtoRD",
        pos: new pos(-1, 1)
    },
    {
        name: "UtoD",
        pos: new pos(1, 0)
    },
    {
        name: "RUtoLD",
        pos: new pos(1, 1)
    }
]