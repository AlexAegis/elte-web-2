let currentPlayer = 0
let fields = []
let winState
let size
let checking = null
let step = 0

// you need ((size * size) / 2) many icons to fill a square
// these 18 icons will fit for a sqrt(18 * 2) = 6 size table
let allIcons = [
	'blind',
	'bowling-ball',
	'car',
	'chess-pawn',
	'cloud',
	'envelope',
	'fighter-jet',
	'fire',
	'flask',
	'gift',
	'headphones',
	'lemon',
	'location-arrow',
	'male',
	'money-bill-alt',
	'music',
	'umbrella',
	'heart'
]
let game
let icons = []
// icon for the back of the fields
let backsideIcon = 'expand'
//let iconSize = '4x'

$(document).ready(() => {
	game = document.getElementById('memoryGame')
	$('#mainMenu').show()
	$('#gamePage').hide()
	$('#startButton').click(() => {
		icons = []
		game.innerHTML = ''
		for (let i = 0; i < Math.pow($("#sizeSelect").val(), 2) / 2; i++) {
			icons.push(allIcons[i])
		}
		$('#mainMenu').hide()
		$('#gamePage').show()
		start()
		
	})
	
	$("#backButton").click(() => {
		$('#mainMenu').show()
		$('#gamePage').hide()
	})
	
})


function start() {
	
	size = Math.sqrt(icons.length * 2)
	console.log(size)
	let arr = []
	while (arr.length < size * size) {
		let rng = Math.floor(Math.random() * size * size) + 1
		if (arr.indexOf(rng) > -1) continue
		arr[arr.length] = rng
	}
	console.log(arr)
	
	
	let table = document.createElement('table')
	table.className += 'table table-responsive borderless'
	
	let tableBody = document.createElement('tbody')
	table.appendChild(tableBody)
	
	fields = []
	for (let i = 0; i < size; i++) {
		let tableRow = document.createElement('tr')
		for (let j = 0; j < size; j++) {
			let fld = new field(new pos(i, j), icons[arr[i * size + j] % (arr.length / 2)])
			fields.push(fld)
			tableRow.appendChild(fld.td)
		}
		tableBody.appendChild(tableRow)
	}
	game.appendChild(table)
}

class field {
	constructor(pos, icon) {
		this.pos = pos
		
		this.backIcon = document.createElement('span')
		this.backIcon.className += 'fas fa-' + backsideIcon
		this.backSide = document.createElement('div')
		this.backSide.className += 'back'
		this.backSide.appendChild(this.backIcon)
		
		this.frontIcon = document.createElement('span')
		this.frontIcon.className += 'fas fa-' + icon
		this.frontSide = document.createElement('div')
		this.frontSide.className += 'front'
		this.frontSide.appendChild(this.frontIcon)
		
		this.flipper = document.createElement('div')
		this.flipper.className += 'flipper'
		this.flipper.appendChild(this.frontSide)
		this.flipper.appendChild(this.backSide)
		
		this.flippable = document.createElement('div')
		this.flippable.className += 'flip-container'
		this.flippable.appendChild(this.flipper)
		
		this.td = document.createElement('td')
		this.td.setAttribute('id', 'field' + this.pos)
		this.td.appendChild(this.flippable)
		
		this.flipper.addEventListener('click', () => this.step())
	}
	
	toString() {
		return 'pos: ' + this.pos.toString()
	}
	
	step() {
		console.log('step: ' + step)
		if (!winState && !this.flipping) {
			step++
			if (!this.found && this !== checking) {
				this.flip()
				if (checking === null) {
					checking = this
				} else {
					if (checking.frontIcon.className === this.frontIcon.className) {
						checking.found = true
						this.found = true
						checking = null
					} else {
						this.checking = checking
						checking = null
						setTimeout(() => {
							this.checking.flip()
							this.flip()
							this.checking = null
						}, 800)
					}
				}
			}
		}
		winState = checkWin()
		console.log('checkWin: ' + winState)
	}
	
	flip() {
		console.log('asd')
		
		this.flipped = !this.flipped
		$(this.flippable).toggleClass('hover')
		this.flipping = true
		setTimeout(() => {
			this.flipping = false
		}, 800)
	}
}

class pos {
	constructor(x, y) {
		this.x = x
		this.y = y
	}
	
	toString() {
		return this.x + ',' + this.y
	}
}

function checkWin() {
	let won = isWin()
	if (won) {
		console.log('LEL')
	}
	return won
}

function isWin() {
	return fields.every(field => field.found)
}