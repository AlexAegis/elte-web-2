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
// icon for the back of the fields
let backsideIcon = "expand"
let iconSize = "5x"

$(document).ready(function () {
    //let fb = document.getElementById("flipButton")

    //fb.addEventListener("click", () =>  document.getElementById("flipdiv").classList.toggle("flip"))

    size = Math.sqrt(icons.length * 2)
    let game = document.getElementById("memoryGame")
    let table = document.createElement("table")

    let tableBody = document.createElement("tbody")
    table.appendChild(tableBody)

    fields = []
    for (let i = 0; i < size; i++) {
        let tableRow = document.createElement("tr")
        for (let j = 0; j < size; j++) {
            let field = createFlippableField(new pos(i, j), "camera-retro")
            fields.push(field)
            tableRow.appendChild(field.td)
        }
        tableBody.appendChild(tableRow)
    }
    game.appendChild(table)
});

function createFlippableField(pos, icon) {
    let fld = new field(pos);

    let backicon = document.createElement("span")
    backicon.className += "fas fa-" + iconSize + " fa-" + backsideIcon
    let backside = document.createElement("div")
    backside.className += "back"
    backside.appendChild(backicon)

    let fronticon = document.createElement("span")
    fronticon.className += "fas fa-" + iconSize + " fa-" + icon
    let frontside = document.createElement("div")
    frontside.className += "front"
    frontside.appendChild(fronticon)

    let flipper = document.createElement("div")
    flipper.className += "flipper"
    flipper.appendChild(frontside)
    flipper.appendChild(backside)

    let flippable = document.createElement("div")
    flippable.className += "flip-container"
    flippable.appendChild(flipper)

    fld.td = document.createElement("td")
    fld.td.setAttribute("id", "field" + fld.pos)
    fld.td.appendChild(flippable)

    //flippable.addEventListener("click", fld.flip())
    fld.flp = flippable
    fld.td.addEventListener("click", fld.flip())
    return fld;
}

class field {
    constructor(pos) {
        this.pos = pos
    }

    toString() {
        return "pos: " + this.pos.toString() + ", mark: " + this.mark
    }

    flip() {
        //this.flp.toggleClass('hover')
        console.log("FLIIII")
    }
}


$(document).on("click", ".flip-container", function () {
    $(this).toggleClass('hover')
    console.log(this.flip())
});


class pos {
    constructor(x, y) {
        this.x = x
        this.y = y
    }

    toString() {
        return this.x + "," + this.y
    }
}