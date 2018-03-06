window.onload = init;

function $(id) {
	return document.getElementById(id)
}

function init() {
	//$('send').addEventListener("click", $('form').submit(), false)
	$("form").addEventListener("submit", validate)
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