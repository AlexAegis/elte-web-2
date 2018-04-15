let currentPlayer
let player1
let player2
let fields = []
let winState
let size
let checking = null
let player1Score
let player2Score
let step = 0
let gameMode
let aiTurn



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
	$('#winPage').hide()
	$('#startButton').click(() => {
		icons = []
		game.innerHTML = ''
		for (let i = 0; i < Math.pow($("#sizeSelect").val(), 2) / 2; i++) {
			icons.push(allIcons[i])
		}
		$('#mainMenu').hide()
		$('#gamePage').show()
		$('#winPage').hide()
		gameMode = $('#modeSelect').val()
		if(gameMode == 1) {
			$('#gameState').hide()
		} else {
			$('#gameState').show()
		}
		start()
		
	})
	
	$("#backButton").click(() => {
		$('#mainMenu').show()
		$('#gamePage').hide()
		$('#winPage').hide()
	})
	
	$("#restartButton").click(() => {
		$('#mainMenu').show()
		$('#gamePage').hide()
		$('#winPage').hide()
	})
	
})


function start() {
	player1Score = 0
	player2Score = 0
	aiTurn = false
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
		tableRow.className += 'row'
		for (let j = 0; j < size; j++) {
			let fld = new field(new pos(i, j), icons[arr[i * size + j] % (arr.length / 2)])
			fields.push(fld)
			tableRow.appendChild(fld.td)
		}
		tableBody.appendChild(tableRow)
	}
	game.appendChild(table)
	player1 = $('#player1')
	player2 = $('#player2')
	currentPlayer = player2
	changePlayer()

}

function changePlayer() {
	if(currentPlayer.attr('id') === player1.attr('id')) {
		currentPlayer = player2
		player1.removeClass('active')
		player2.addClass('active')
		
		player1.removeClass('fas')
		player1.addClass('far')
		player2.removeClass('far')
		player2.addClass('fas')
	} else if(currentPlayer.attr('id') === player2.attr('id')) {
		currentPlayer = player1
		player1.addClass('active')
		player2.removeClass('active')
		
		player2.removeClass('fas')
		player2.addClass('far')
		player1.removeClass('far')
		player1.addClass('fas')
	}
}

class field {
	constructor(pos, icon) {
		this.pos = pos
		
		this.backIcon = document.createElement('span')
		this.backIcon.className += 'fas fa-' + backsideIcon
		console.log("size" + size)
		if(size === 4) {
			this.backIcon.className += ' fa-4x'
		} else if(size === 6) {
			this.backIcon.className += ' fa-2x'
		}
		
		this.backSide = document.createElement('div')
		if(size === 4) {
			this.backSide.className += 'back back4'
		} else if(size === 6) {
			this.backSide.className += 'back back6'
		}
		this.backSide.appendChild(this.backIcon)
		
		this.frontIcon = document.createElement('span')
		this.frontIcon.className += 'fas fa-' + icon
		if(size === 4) {
			this.frontIcon.className += ' fa-4x'
		} else if(size === 6) {
			this.frontIcon.className += ' fa-2x'
		}
		
		this.frontSide = document.createElement('div')
		if(size === 4) {
			this.frontSide.className += 'front front4'
		} else if(size === 6) {
			this.frontSide.className += 'front front6'
		}
		this.frontSide.appendChild(this.frontIcon)
		
		this.flipper = document.createElement('div')
		this.flipper.className += 'flipper'
		this.flipper.appendChild(this.frontSide)
		this.flipper.appendChild(this.backSide)
		
		this.flippable = document.createElement('div')
		this.flippable.className += ' flip-container'
		if(size === 4) {
			this.flippable.className += ' flip-container4'
		} else if(size === 6) {
			this.flippable.className += ' flip-container6'
		}
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
		if (!winState && !this.flipping && !aiTurn) {
			step++
			if (!this.found && this !== checking) {
				this.flip()
				if (checking === null) {
					checking = this
				} else {
					if (checking.frontIcon.className === this.frontIcon.className) {
						checking.found = true
						this.found = true
						
						this.checking = checking
						
						if(currentPlayer === player1) {
							player1Score += 2
							console.log('P1 STEP')
						} else if(currentPlayer === player2) {
							player2Score += 2
							console.log('P2 STEP')
						}
						setTimeout(() => {
							$(this.checking.backSide).hide()
							$(this.backSide).hide()
							updateScore()
						}, 800)
						
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
		
		if(step === 2) {
			step = 0
			if(gameMode !== 1) {
				setTimeout(() => {
					changePlayer()
				}, 800)
				if(gameMode === 0) {
					aiTurn = true
					setTimeout(() => {
						aiStep()
						aiTurn = false
					}, 800)
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

function aiStep() {
	remaining = fields.filter(field => !field.found && !field.flipped)
	let number = Math.floor(Math.random() * remaining.length) + 1
	console.log("nummber: " + number)
	
}

function updateScore() {
	$('#player1Score').html(player1Score)
	$('#player2Score').html(player2Score)
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
		if(currentPlayer === player1) {
			if(gameMode === 0) {
				$('#winMessage').html('A játékos nyert!')
			} else {
				$('#winMessage').html('Az első játékos nyert!')
			}
		} else if(currentPlayer === player2) {
			if(gameMode === 0) {
				$('#winMessage').html('A gép nyert!')
			} else {
				$('#winMessage').html('Az második játékos nyert!')
			}
		}
		setTimeout(() => {
			$('#mainMenu').hide()
			$('#gamePage').hide()
			$('#winPage').show()
		}, 800)
	}
	
	
	return won
}

function isWin() {
	return fields.every(field => field.found)
}