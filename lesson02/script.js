function $(id) {
	return document.getElementById(id);
}

function init() {
	$('printButton').onclick = printHello;
	$('switchButton').onclick = switchFields;
	$('radiusButton').onclick = calculateRadius;
	$('guessButton').onclick = guess;
	$('translateButton').onclick = translate;
}

// Task 1

function printHello() {
	var n = $('howMany').value;
	var s = "";
	for(var i = 1; i <= n; i++) {
		s += "<p style='font-size: " + (i * 5) + "px'>Hello</p>";
	}
	$('result').innerHTML = s;
}

// Task 2

function switchFields() {
	var tmp = $('switchField1').value;
	$('switchField1').value = $('switchField2').value;
	$('switchField2').value = tmp;
}

// Task 3

function calculateRadius() {
	$('radiusResult').innerHTML = Math.round(2 * Math.PI * $('radiusField').value * 100) / 100;
}

// Task 4

var randomNumber = null;

function guess() {
	if(randomNumber === null) {
		randomNumber = Math.floor(Math.random() * 100);
	}
	
	if($('guessField').value !== null) {
		if($('guessField').value > randomNumber) {
			$('guessResult').innerHTML = "&#9660";
		} else if($('guessField').value < randomNumber) {
			$('guessResult').innerHTML = "&#9650";
		} else if($('guessField').value == randomNumber) {
			$('guessResult').innerHTML = "Guessed right!";
		} else {
			$('guessResult').innerHTML = "Invalid";
		}
		
	} else {
	}
	
	if(guess === randomNumber) {
		randomNumber = null;
	}
}

// Task 5

var dict = [
	{ eng: 'apple', hun: 'alma'},
	{ eng: 'cat', hun: 'macska'},
	{ eng: 'dog', hun: 'kutya'},
	{ eng: 'tomato', hun: 'paradicsom'}
];

function translate() {
	if(dict.find(o => o.eng === $('translateField').value || o.hun === $('translateField').value) > dict.size) {
		$('translateResult').innerHTML = "NO";
	} else {
		$('translateResult').innerHTML = "YES";
	}

}

window.onload = init;