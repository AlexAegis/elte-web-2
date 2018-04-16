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
let aiTurn
let winner

let state // page state
let mode // game mode
let diff // game difficulty (colors)

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
	state = getUrlParameter('state')
	if (state === undefined || state === '' || state === 'menu') {
		initMenu()
	} else if (state === 'game') {
		initGame()
	} else if(state === 'win') {
		initWin()
	}
})

function loadMenu() {
	setParam('state', 'menu')
	removeParam('mode')
	removeParam('size')
	removeParam('diff')
	removeParam('winner')
	initMenu()
}

/**
 *
 * @param mode 0 for AI, 1 for single player, 2 for local multi player, if not valid 1 will be used
 * @param size 4 or 6, if not valid, 4 will be used
 * @param diff 0 for Easy (colored) 1 for Hard (colorless)
 */
function loadGame(mode, size, diff) {
	setParam('state', 'game')
	setParam('mode', mode)
	setParam('size', size)
	setParam('diff', diff)
	removeParam('winner')
	initGame()
}

function loadWin(player) {
	setParam('state', 'win')
	setParam('winner', player)
	removeParam('mode')
	removeParam('size')
	removeParam('diff')
	initWin()
}

function initMenu() {
	$('#content').load('menu.html')
}

function initGame() {
	mode = parseInt(getUrlParameter('mode'))
	size = parseInt(getUrlParameter('size'))
	diff = parseInt(getUrlParameter('diff'))
	
	if (mode !== 0 && mode !== 1 && mode !== 2) {
		mode = 1 // default game mode
	}
	if (size !== 4 && size !== 6) {
		size = 4
	}
	if(diff !== 0 && diff !== 1) {
		diff = 0
	}
	
	$('#content').load('game.html', () => {
		game = document.getElementById('memoryGame')
		
		icons = []
		game.innerHTML = ''
		for (let i = 0; i < Math.pow(size, 2) / 2; i++) {
			icons.push(allIcons[i])
		}
		
		if (mode === '1') {
			$('#player2').hide()
			$('#player2Score').hide()
		} else {
			$('#player2').show()
			$('#player2Score').show()
		}
		start()
	})
}

function initWin() {
	winner = parseInt(getUrlParameter('winner'))
	mode = parseInt(getUrlParameter('mode'))
	$('#content').load('win.html', () => {
		if (winner === 1) {
			if (mode === 0) {
				$('#winMessage').html('A játékos nyert!')
			} else if(mode === 1) {
				$('#winMessage').html('Gratulálok!')
			} else {
				$('#winMessage').html('Az első játékos nyert!')
			}
		} else if (winner === 2) {
			if (mode === 0) {
				$('#winMessage').html('A gép nyert!')
			} else if(mode === 2) {
				$('#winMessage').html('Az második játékos nyert!')
			} else {
				$('#winMessage').html('Te kis vicces')
			}
		} else {
			$('#winMessage').html('Döntetlen!')
		}
	})
}

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
	
	
	let table = document.createElement('div')
	table.className += 'borderless'
	
	let tableBody = document.createElement('div')
	table.appendChild(tableBody)
	
	fields = []
	for (let i = 0; i < size; i++) {
		let tableRow = document.createElement('div')
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
	if (currentPlayer.attr('id') === player1.attr('id')) {
		currentPlayer = player2
		player1.removeClass('active')
		player2.addClass('active')
	} else if (currentPlayer.attr('id') === player2.attr('id')) {
		currentPlayer = player1
		player1.addClass('active')
		player2.removeClass('active')
	}
}

class field {
	constructor(pos, icon) {
		this.pos = pos
		
		this.backIcon = document.createElement('span')
		this.backIcon.className += 'fas fa-' + backsideIcon
		console.log('size' + size)
		if (size === 4) {
			this.backIcon.className += ' fa-5x'
		} else if (size === 6) {
			this.backIcon.className += ' fa-3x'
		}
		
		this.backSide = document.createElement('div')
		if (size === 4) {
			this.backSide.className += 'back back4'
		} else if (size === 6) {
			this.backSide.className += 'back back6'
		}
		this.backSide.appendChild(this.backIcon)
		
		this.frontIcon = document.createElement('span')
		this.frontIcon.className += 'fas fa-' + icon
		if (size === 4) {
			this.frontIcon.className += ' fa-4x'
		} else if (size === 6) {
			this.frontIcon.className += ' fa-2x'
		}
		
		console.log('this.frontIcon.style.color ' + this.frontIcon.style.color)
		if(diff === 0) {
			this.frontIcon.setAttribute('style', 'color: #' + this.color())
		}
		console.log('this.frontIcon.style.color ' + this.frontIcon.style.color)
		
		this.frontSide = document.createElement('div')
		if (size === 4) {
			this.frontSide.className += 'front front4'
		} else if (size === 6) {
			this.frontSide.className += 'front front6'
		}
		this.frontSide.appendChild(this.frontIcon)
		
		this.flipper = document.createElement('div')
		this.flipper.className += 'flipper'
		this.flipper.appendChild(this.frontSide)
		this.flipper.appendChild(this.backSide)
		
		this.flippable = document.createElement('div')
		this.flippable.className += ' flip-container'
		if (size === 4) {
			this.flippable.className += ' flip-container4'
		} else if (size === 6) {
			this.flippable.className += ' flip-container6'
		}
		this.flippable.appendChild(this.flipper)
		
		this.td = document.createElement('div')
		this.td.setAttribute('id', 'field' + this.pos)
		this.td.setAttribute('class', 'col')
		this.td.appendChild(this.flippable)
		
		this.flipper.addEventListener('click', () => this.step())
	}
	
	toString() {
		return 'pos: ' + this.pos.toString()
	}
	
	step() {
		if (!aiTurn) {
			console.log('go ahead')
			this.doStep()
		} else {
			console.log('no its ai turn')
		}
	}
	
	doStep() {
		//console.log('step: ' + step)
		if (!winState && !this.flipping) {
			step++
			if (!this.found && this !== checking) {
				this.flip()
				if (checking === null) {
					checking = this
				} else {
					if (checking.frontIcon.className === this.frontIcon.className) {
						this.checking = checking
						this.checking.found = true
						this.found = true
						
						if (currentPlayer === player1) {
							player1Score += 2
							//console.log('P1 STEP')
						} else if (currentPlayer === player2) {
							player2Score += 2
							//console.log('P2 STEP')
						}
						setTimeout(() => {
							$(this.checking.backSide).hide()
							$(this.backSide).hide()
							$(this.checking.frontSide).hide()
							$(this.frontSide).hide()
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
		
		if (step === 2) {
			step = 0
			if (mode !== 1) {
				setTimeout(() => {
					changePlayer()
				}, 800)
				if (mode === 0) {
					//console.log('AITURN')
					if (!aiTurn) {
						aiTurn = true
						setTimeout(() => {
							aiStep()
						}, 800)
					}
					
				}
			}
		}
		winState = checkWin()
		//console.log('checkWin: ' + winState)
	}
	
	flip() {
		//console.log('asd')
		
		this.flipped = !this.flipped
		$(this.flippable).toggleClass('hover')
		this.flipping = true
		setTimeout(() => {
			this.flipping = false
		}, 800)
	}
	
	hashCode() {
		let str = this.frontIcon.className
		let hash = 0
		for (let i = 0; i < str.length; i++) {
			hash = str.charCodeAt(i) + ((hash <<2) - hash * 7.4)
		}
		return hash
	}
	
	color() {
		let c = (this.hashCode() & 0x00FFFFFF)
			.toString(16)
			.toUpperCase()
		return '00000'.substring(0, 6 - c.length) + c
	}
}

function aiStep() {
	setTimeout(() => {
		let remaining = fields.filter(field => !field.found && !field.flipped)
		remaining[Math.floor(Math.random() * remaining.length)].doStep()
		setTimeout(() => {
			remaining = fields.filter(field => !field.found && !field.flipped)
			remaining[Math.floor(Math.random() * remaining.length)].doStep()
			setTimeout(() => {
				aiTurn = false
				step = 0
			}, 1600)
		}, 800)
	}, 800)
	
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
		setTimeout(() => {
			if (player1Score > player2Score) {
				loadWin(1)
			} else if (player1Score < player2Score) {
				loadWin(2)
			} else {
				loadWin(0)
			}
		}, 800)
	}
	return won
}

function isWin() {
	return fields.every(field => field.found)
}

