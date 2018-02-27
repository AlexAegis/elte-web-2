window.onload = init;

function $(id) {
	return document.getElementById(id);
}

function init() {
	$('par').addEventListener('click', parClick, false);
	$('autoComplete').addEventListener('keyup', autoComplete, false);
	initTicTacToe();
}

// 2. Feladat
// A paragrafusra kattintáskor írd ki a konzolra:
function parClick(e) {
	// a) az eseményt jelző objektumot;
	console.log(e);
	// b) az esemény típusát;
	console.log(e.type);
	// 	c) a kattintás közben lenyomott egérgombot;
	console.log(e.button);
	// d) az egér kattintáskori pozícióját;
	console.log(e.pageX + ", " + e.pageY);
	// e) az eseményt eredetileg jelző objektumot;
	console.log(e.target);
	// f) span elemre kattintva a span elem szövegét.
	if(e.target.tagName == 'SPAN') {
		console.log(e.target.innerHTML);
	}
	// g) Ha a hivatkozás szövege “libero”, akkor ne kövesse a hivatkozást.
	if(e.target.tagName  == 'A' && e.target.innerHTML == 'libero') {
		e.preventDefault();
	}
}

// 3. Feladat
var movies = [
	{
		title: 'Hobbit',
		year: 2012
	},
	{
		title: 'A nagy ho-ho-ho-horgász',
		year: 1990
	},
	{
		title: 'A három testőr',
		year: 2000
	}
]

function autoComplete(e) {
	$('autoList').innerHTML = movies.filter(movie => $('autoComplete').value != "" && movie.title.includes($('autoComplete').value))
		.map(movie => "<li>" + movie.title + "</li>")
		.join("");
}

// 4. Feladat
var size = 3
var currentPlayer = "X"
var fields = []

function initTicTacToe() {
	currentPlayer = "X"
	initDataStructure()
	renderTicTacTable()
	for(var fieldRow of fields) {
		for(var field of fieldRow) {
			$("field" + field.pos).addEventListener('click', placeTick, false)
		}
	}
}

function initDataStructure() {
	fields = []
	for(var i = 0; i < size; i++) {
		var fieldRow = []
		for(var j = 0; j < size; j++) {
			fieldRow.push(
				{
					pos: i + "," + j, 
					val: "a"
				}
			)
		}
		fields.push(fieldRow);
	}
}

function renderTicTacTable() {
	var board = "<table id=\"tictactoeTable\">"
	for(var fieldRow of fields) {
		var row = "<tr>"
		for(var field of fieldRow) {
			row = row + "<td id=\"field" + field.pos + "\">" + field.val + "</td>"
		}
		board = board + row + "</tr>"
	}
	$('tictactoe').innerHTML = board + "</table>"
}


function placeTick(e) {
	e.target.innerHTML = "X";
	console.log(e)

}