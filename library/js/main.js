
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