window.onload = init;

function $(id) {
	return document.getElementById(id)
}

function init() {
	$("form").addEventListener("submit", validate)
	initMap()
}

function validate(e) {
	let errors = []
	let errorsElement = $('errors')
	errorsElement.innerHTML = ""

	let age = $("age").value
	let name = $("name").value
	let interest = $("interest").value

	if(name === undefined || name === "") {
		errors.push(createError("Name is mandatory"))
	}

	if( age === undefined || age === "" || !/^\d+$/.test(age)) {
		errors.push(createError("age is mandatory"))
	}

	if(interest === undefined || interest === "") {
		errors.push(createError("interest is mandatory"))
	}	

	if(errors.length > 0) {
		e.preventDefault()
		errors.forEach(err => errorsElement.appendChild(err))
	}
}

function createError(message) {
	let error = document.createElement("li")
	error.innerHTML = message
	error.setAttribute("class",  "error")
	return error
}

let fields = []
let size = 3
let winState
let counter
let counterElement 

function initMap() {
	let map = $('map')
	counterElement= $('counter')
	counter = 0
	
	winState = false
    fields = []
    let sizeFieldVal = $('sizeField').value
    if(sizeFieldVal !== undefined && sizeFieldVal !== "") {
        console.log(sizeFieldVal)
        size = sizeFieldVal
    } else {
        size = 3
        $('sizeField').value = size
    }

	map.innerHTML = ''

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
            tableData.addEventListener("click", guessField, false)
            tableData.setAttribute("id", "field" + field.pos)
            tableRow.appendChild(tableData)
        })
        tableBody.appendChild(tableRow)
	}
	
	

	$('map').appendChild(table)
	
	let fld = fieldByPos(new pos(random(1, size), random(1, size)))
	console.log(fld)
	fld.mark = "X"
}

function random(from, to) {
	return Math.floor((Math.random() * to - 1) + from)
}

function guessField(e) {
    let posArr = e.target.id.split("field")[1].split(",")
	let field = fieldByPos(new pos(posArr[0], posArr[1]))
	if(!winState && field.td.innerHTML === "") {
		if(checkWin(field) ) {
			winState = true
			field.td.innerHTML = "X"
		} else {
			field.td.innerHTML = "O"
			counter += 1
		}	
	}
	counterElement.innerHTML = counter
}

function fieldByPos(posObj) {
    return fields.filter(field => field.pos.toString() === posObj.toString()).pop()
}

function checkWin(fieldClicked) {
	console.log(fieldClicked + " " + fieldClicked.mark)
	return fieldClicked.mark !== undefined
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