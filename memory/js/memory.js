let currentPlayer
let fields = []
let winState
let size

// you need ((size * size) / 2) many icons to fill
// these 18 icons will fit for a sqrt(18 * 2) = 6 size table
let icons = [
    "blind",
    "bowling-ball",
    "car",
    "chess-pawn",
    "cloud",
    "envelope",
    "fighter-jet",
    "fire",
    "flask",
    "gift",
    "headphones",
    "lemon",
    "location-arrow",
    "male",
    "money-bill-alt",
    "music",
    "umbrella",
    "xbox"
]

$(document).ready(function () {
    size = Math.sqrt(icons.length * 2)
    let game = document.getElementById("memoryGame")
    let table = document.createElement("table")

    let tableBody = document.createElement("tbody")
    table.appendChild(tableBody)

    fields = []
    for (let i = 0; i < size; i++) {
        for (let j = 0; j < size; j++) {
            fields.push(new field(new pos(i, j)))
        }
    }

    for (let i = 0; i < size; i++) {
        let tableRow = document.createElement("tr")
        fields.filter(field => field.pos.y === i).forEach(field => {
            let tableData = document.createElement("td")
            let icon = document.createElement("i")
            icon.className += "fas fa-5x fa-camera-retro"
            field.td = tableData
            field.td.setAttribute("id", "field" + field.pos)
            field.td.appendChild(icon)
            tableRow.appendChild(tableData)
        })
        tableBody.appendChild(tableRow)
    }
    game.appendChild(table)
});


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