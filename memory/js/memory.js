let currentPlayer
let fields = []
let winState
let size
let checking = null
let step = 0

// you need ((size * size) / 2) many icons to fill a square
// these 18 icons will fit for a sqrt(18 * 2) = 6 size table
let icons = [
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
	'xbox'
]
// icon for the back of the fields
let backsideIcon = 'expand'
let iconSize = '5x'

$(document).ready(() => {
	size = Math.sqrt(icons.length * 2)
	
	let arr = []
	while(arr.length < size * size){
		let rng = Math.floor(Math.random() * size * size) + 1;
		if(arr.indexOf(rng) > -1) continue;
		arr[arr.length] = rng;
	}
	console.log(arr)
	
	
	
	let game = document.getElementById('memoryGame')
	let table = document.createElement('table')
	
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
})



class field {
	constructor(pos, icon) {
		this.pos = pos
		
		this.backIcon = document.createElement('span')
		this.backIcon.className += 'fas fa-' + iconSize + ' fa-' + backsideIcon
		this.backSide = document.createElement('div')
		this.backSide.className += 'back'
		this.backSide.appendChild(this.backIcon)
		
		this.frontIcon = document.createElement('span')
		this.frontIcon.className += 'fas fa-' + iconSize + ' fa-' + icon
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
		return 'pos: ' + this.pos.toString() + ', mark: ' + this.mark
	}
	
	step() {
		if (!winState) {
			step++;
			if(!this.found && this !== checking) {
				this.flip()
				if(checking === null) {
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
						}, 1000);
						
					}
				}
			}
		}
		winState = checkWin()
		console.log('checkWin: ' + winState)
	}
	
	flip() {
		this.flipped = !this.flipped
		$(this.flippable).toggleClass('hover')
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
	if(won) {
		console.log("LEL")
	}
	return won
}

function isWin() {
	return fields.every(field => field.found)
}