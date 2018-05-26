$(document).ready(init());

function init(removeParams = false) {
	if(removeParams) {
		removeParam();
	}
	$.ajax({
		type: "GET",
		url: window.location.pathname + '/class/session.php',
		data: {
			action: 'session'
		},
		success: function(response) {
			let jsonResponse = JSON.parse(response);
			switch (jsonResponse.result) {
				case 'logged':
					if (getParam('page') === 'book') {
						loadBookPage();
					} else {
						loadMainPage();
					}
					break;
				case 'not logged':
					loadWelcomePage(() => {
						$('#email').focus();
					});
					break;
			}
		}
	});
	
	$(document).click(function (event) {
		let clickover = $(event.target);
		let _opened = $(".navbar-collapse").hasClass("navbar-collapse in");
		if (_opened === true && !clickover.hasClass("navbar-toggle")) {
			$("button.navbar-toggle").click();
		}
	});
}

function loadWelcomePage(callback) {
	$('#user').load(window.location.pathname + '/content/user/login.php', callback);
	$('#navigation').html('');
	//$('#navigation').load(window.location.pathname + '/content/navigation.php');
	$('#content').load(window.location.pathname + '/content/welcome.php', callback);
}

function loadMainPage(callback) {
	$('#user').load(window.location.pathname + '/content/user/logout.php', callback);
	$('#navigation').load(window.location.pathname + '/content/navigation.php');
	$('#content').load(window.location.pathname + '/content/main.php', callback);
}

function loadBookPage() {
	$('#content').load(
		window.location.pathname + '/content/book.php'
	);
}

function userController(data, action) {
	$.ajax({
		type: "POST",
		url: window.location.pathname + 'class/userController.php',
		data: data.serialize() + '&action=' + action,
		success: function(response) {
			let jsonResponse = JSON.parse(response);
			switch (jsonResponse.result) {
				case 'loginSuccess':
					loadMainPage();
					$('.navbar-collapse').collapse('hide');
					break;
				case 'loginError':
					if(jsonResponse.errors.includes('invalidPassword')) {
						$('#password').addClass('is-invalid');
					}
					if(jsonResponse.errors.includes('invalidEmail')) {
						$('#email').addClass('is-invalid');
					}
					break;
				case 'registrationSuccess':
					loadWelcomePage(() => {
						$('#email').val(jsonResponse.email);
						$('#password').val(jsonResponse.password);
						$('#login').focus();
					});
					break;
				case 'registrationError':
					if(jsonResponse.errors.includes('nameAlreadyTaken')) {
						$('#registrationName').addClass('is-invalid');
					}
					if(jsonResponse.errors.includes('emailAlreadyTaken')) {
						$('#registrationEmail').addClass('is-invalid');
					}
					break;
				case 'navigateRegistration':
					$('#content').load(window.location.pathname + '/content/registration.php', () => {
						let dataArray = data.serializeArray();
						let email = dataArray.filter(e => e.name === 'email').map(e => e.value)[0];
						let regName = $('#registrationName');
						if (email.indexOf('@') > -1) {
							$('#registrationEmail').val(email);
							regName.val(email.split('@')[0]);
						} else {
							regName.val(email);
						}
						regName.focus();
						$('#registrationPassword').val(dataArray.filter(e => e.name === 'password').map(e => e.value)[0]);
					});
					break;
			}
		}
	});
}


function bookController(data, action) {
	$.ajax({
		type: "POST",
		url: window.location.pathname + 'class/bookController.php',
		data: data.serialize() + '&action=' + action,
		success: function(response) {
			let jsonResponse = JSON.parse(response);
			switch (jsonResponse.result) {
				case 'loginSuccess':
					
					break;
			}
		}
	});
}

function logout() {
	$.ajax({
		type: "POST",
		url: window.location.pathname + '/class/session.php',
		data: {
			action: 'logout',
			parameter: ''
		},
		success: function(response) {
			let jsonResponse = JSON.parse(response);
			if (jsonResponse.result === 'logout') {
				init(true);
			}
		}
	});
}