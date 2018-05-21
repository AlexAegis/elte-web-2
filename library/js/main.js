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
				$('#header').load(window.location.pathname + '/content/logout.html', data);
				$('#content').load(window.location.pathname + '/content/main.html', data);
			} else {
				$('#header').load(window.location.pathname + '/content/login.html', data);
				$('#content').load(window.location.pathname + '/content/welcome.html', data);
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