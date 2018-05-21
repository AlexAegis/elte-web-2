$(document).ready(init());

function init() {
	$.ajax({
		type: "POST",
		url: window.location.pathname + '/class/session.php',
		data: {
			action: 'login'
		},
		success: function(data) {
			console.log('session response:' + data);
			if (data === 'logged') {
				$('body').load(window.location.pathname + '/content/main.html', data, () => {
					console.log('MAIN BODY LOADED')
				});
			} else {
				$('body').load(window.location.pathname + '/content/login.html', data, () => {
					console.log('LOGIN BODY LOADED')
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
			action: 'logout'
		},
		success: function(data) {
			if (data === 'success') {
				$('body').load(window.location.pathname + 'index.html', null, () => {
					console.log('BODY LOADED')
				});
			} else {
				console.log('NO SUCC ON LOGOUT')
			}
		}
	});
}