window.onload = init;

function $(id) {
	return document.getElementById(id)
}

function init() {
	$("changeParagraphButton").addEventListener("click", changeStyle)
	$("startCountdown").addEventListener("click", startCountdown)
}

// Task 1
function changeStyle(e) {
	$('paragraph').className += 'paragraphStyle '
}

function disappear() {
	let par = $(paragraph)
	if(par.style.display === 'none') {
			par.style.opacity = 1
			par.style.display = ''
	} else {
		par.style.opacity = 0
		par.addEventListener('transitionend', animEnd, false)
	}
}

function animEnd(e) {
	let par = $(paragraph)
	par.style.display = 'none'
	par.removeEventListener('transitionend', animEnd, false)
}

// Task 2

let elapsedTime = 0
let totalTime = 119
let totalWidth = 400

function startCountdown(e) {
	let prog = $('progress')
	let timer = $('timer')
	let to = setInterval(function () {
		prog.style.width = (totalWidth / totalTime) * (elapsedTime) + 'px'
		elapsedTime += 1
		timer.innerHTML = Math.floor(elapsedTime / 60).toLocaleString('en-US', {minimumIntegerDigits: 2, useGrouping:false}) 
		+ ':' 
		+ (elapsedTime % 60).toLocaleString('en-US', {minimumIntegerDigits: 2, useGrouping:false})
		if(elapsedTime > totalTime) {
			clearInterval(to)
		}
	}, 1000);
}