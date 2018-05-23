$(document).ready(init());

function init() {
	$.ajax({
		type: "POST",
		url: window.location.pathname + '/class/session.php',
		data: {
			action: 'login'
		},
		success: function(response) {
			if (response === 'logged') {
				loadMainPage();
			} else {
				loadWelcomePage(() => {
					$('#email').focus();
				});
			}
		}
	});
}

function loadWelcomePage(callback) {
	$('#user').load(window.location.pathname + '/content/user/login.php', callback);
	$('#navigation').html('');
	$('#content').load(window.location.pathname + '/content/welcome.php', callback);
}

function loadMainPage(callback) {
	$('#user').load(window.location.pathname + '/content/user/logout.php', callback);
	$('#navigation').load(window.location.pathname + '/content/navigation.php', callback);
	$('#content').load(window.location.pathname + '/content/main.php', callback);
}

function userController(data, action) {
	$.ajax({
		type: "POST",
		url: window.location.pathname + 'class/userController.php',
		data: data.serialize() + '&action=' + action,
		success: function(response) {
			let jsonResponse = JSON.parse(response);
			if (jsonResponse.result === 'loginSuccess') {
				loadMainPage();
			} else if(jsonResponse.result === 'loginError') {
				if(jsonResponse.errors.includes('invalidPassword')) {
					$('#password').addClass('is-invalid');
				}
				if(jsonResponse.errors.includes('invalidEmail')) {
					$('#email').addClass('is-invalid');
				}
			} else if(jsonResponse.result === 'registrationSuccess') {
				loadWelcomePage(() => {
					$('#email').val(jsonResponse.email);
					$('#password').val(jsonResponse.password);
					$('#login').focus();
				});
			} else if(jsonResponse.result === 'registrationError') {
				if(jsonResponse.errors.includes('nameAlreadyTaken')) {
					$('#registrationName').addClass('is-invalid');
				}
				if(jsonResponse.errors.includes('emailAlreadyTaken')) {
					$('#registrationEmail').addClass('is-invalid');
				}
			} else if(jsonResponse.result === 'navigateRegistration') {
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
			if (response === 'success') {
				$('body').load(window.location.pathname + 'index.php', null, init());
			}
		}
	});
	return false;
}

function get(element, action, parameter = null) {
	$.ajax({
		type: "GET",
		url: window.location.pathname + '/class/session.php',
		data: {
			action: action,
			parameter: parameter
		},
		success: function(response) {
			element.html(JSON.parse(response).result);
		}
	});
}

