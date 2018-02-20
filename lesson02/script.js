// JQuery like shortcut function

window.onload = init;

function $(id) {
	return document.getElementById(id);
}



// Button initializer, binds the functions tot he corresponding buttons

function init() {
	// Task 1
	$('printButton').onclick = printHello;
	// This makes the enter key click the button in the corresponding field
	$("howMany").addEventListener("keyup", function(event) {
		event.preventDefault();
		if (event.keyCode === 13) {
			$('printButton').click();
		}
	});
	// Task 2
	$('switchButton').onclick = switchFields;
	$("switchField1").addEventListener("keyup", function(event) {
		event.preventDefault();
		if (event.keyCode === 13) {
			$('switchButton').click();
		}
	});
	$("switchField2").addEventListener("keyup", function(event) {
		event.preventDefault();
		if (event.keyCode === 13) {
			$('switchButton').click();
		}
	});
	// Task 3
	$('radiusButton').onclick = calculateRadius;
	$("radiusField").addEventListener("keyup", function(event) {
		event.preventDefault();
		if (event.keyCode === 13) {
			$('radiusButton').click();
		}
	});
	// Task 4
	$('guessButton').onclick = guess;
	$("guessField").addEventListener("keyup", function(event) {
		event.preventDefault();
		if (event.keyCode === 13) {
			$('guessButton').click();
		}
	});
	// Task 5
	$('translateButton').onclick = translate;
	$("translateField").addEventListener("keyup", function(event) {
		event.preventDefault();
		if (event.keyCode === 13) {
			$('translateButton').click();
		}
	});
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
		resetRandomNumber();
	}
	
	if($('guessField').value > randomNumber) {
		$('guessResult').innerHTML = "&#9660";
	} else if($('guessField').value < randomNumber) {
		$('guessResult').innerHTML = "&#9650";
	} else if($('guessField').value == randomNumber) {
		$('guessResult').innerHTML = "Guessed right!";
		resetRandomNumber();
	} else {	
		$('guessResult').innerHTML = "Invalid";
	}
}

function resetRandomNumber() {
	randomNumber = Math.floor(Math.random() * 100);
}

// Task 5

var dict = [
	{ eng: 'apple', hun: 'alma'},
	{ eng: 'cat', hun: 'macska'},
	{ eng: 'dog', hun: 'kutya'},
	{ eng: 'tomato', hun: 'paradicsom'}
];

function translate() {
	if(dict.findIndex(o => (o.eng === $('translateField').value)) > 0) {
		$('translateResult').innerHTML = (dict.find(o => (o.eng == $('translateField').value)).hun);
	} else if(dict.findIndex(o => (o.hun === $('translateField').value)) > 0) {
		$('translateResult').innerHTML = (dict.find(o => (o.hun == $('translateField').value)).eng);
	} else {
		$('translateResult').innerHTML = "The dictionary doesn't contains this information"
	}
}

