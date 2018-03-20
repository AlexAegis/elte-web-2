window.onload = init;

function $(id) {
	return document.getElementById(id)
}

function init() {
	let button = $("nameCookieButton");
	button.addEventListener("click", nameCookieButton)
}


// Task 1
function nameCookieButton(e) {
	let button = $("nameCookieButton");
	console.log(getCookie("name"))

	if(getCookie("name") == undefined) {

		setCookie("name", $("nameCookieButton").innerHTML, 1)
	} else {
		setCookie("name", "", 1)
	}
	
}

// From: https://www.w3schools.com/js/js_cookies.asp

function setCookie(cname, cvalue, exdays) {
    var d = new Date()
    d.setTime(d.getTime() + (exdays*24*60*60*1000))
    var expires = "expires="+ d.toUTCString()
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/"
}

function getCookie(cname) {
    var name = cname + "="
    var decodedCookie = decodeURIComponent(document.cookie)
    var ca = decodedCookie.split(';')
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i]
        while (c.charAt(0) == ' ') {
            c = c.substring(1)
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length)
        }
    }
    return ""
}