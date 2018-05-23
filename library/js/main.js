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
				$('#user').load(window.location.pathname + '/content/user/logout.php', response);
				$('#navigation').load(window.location.pathname + '/content/navigation.php', response);
				$('#content').load(window.location.pathname + '/content/main.php', response);
			} else {
				$('#user').load(window.location.pathname + '/content/user/login.php', response);
				$('#navigation').html('');
				$('#content').load(window.location.pathname + '/content/welcome.php', response);
			}
		}
	});
}

function userController(data, action) {
	$.ajax({
		type: "POST",
		url: window.location.pathname + 'class/userController.php',
		data: data.serialize() + '&action=' + action,
		success: function(response) {
			let jsonResponse = JSON.parse(response);
			if (jsonResponse.result === 'loginSuccess') {
				$('body').load(window.location.pathname + 'index.php');
			} else if(jsonResponse.result === 'loginError') {
				if(jsonResponse.errors.includes('invalidPassword')) {
					$('#password').addClass('is-invalid');
				} else if(jsonResponse.errors.includes('invalidUsername')) {
					$('#email').addClass('is-invalid');
				}
			} else if(jsonResponse.result === 'registrationError') {
				if(jsonResponse.errors.includes('nameAlreadyTaken')) {
					$('#registrationName').addClass('is-invalid');
				}
				if(jsonResponse.reason.includes('emailAlreadyTaken')) {
					$('#registrationEmail').addClass('is-invalid');
				}
			} else if(jsonResponse.result === 'navigateRegistration') {
				$('#content').load(window.location.pathname + '/content/registration.php', () => {
					let dataArray = data.serializeArray();
					let email = dataArray.filter(e => e.name === 'username').map(e => e.value)[0];
					if (email.indexOf('@') > -1) {
						$('#registrationEmail').val(email);
						$('#registrationName').val(email.split('@')[0]);
					} else {
						$('#registrationName').val(email);
					}
					$('#registrationPassword').val(dataArray.filter(e => e.name === 'password').map(e => e.value)[0]);
				});
			}
		}
	});
	return false;
}

function logout() {
	$.ajax({
		type: "POST",
		url: window.location.pathname + '/class/session.php',
		data: {
			action: 'logout'
		},
		success: function(response) {
			if (response === 'success') {
				$('body').load(window.location.pathname + 'index.php', null, init());
			}
		}
	});
	return false;
}

function get(action, element) {
	$.ajax({
		type: "GET",
		url: window.location.pathname + '/class/session.php',
		data: {
			action: action
		},
		success: function(response) {
			let jsonResponse = JSON.parse(response);
			element.html(jsonResponse.result);
		}
	}, 'html');
}

