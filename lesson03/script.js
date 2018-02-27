window.onload = init;

function $(id) {
	return document.getElementById(id);
}

function init() {
	$('par').addEventListener('click', parClick, false);
}

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