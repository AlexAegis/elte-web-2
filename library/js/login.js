$(document).ready(function() {
	$('#loginForm').submit(function(e) {
		e.preventDefault();
		console.log('AAAAAAAAAAAAAASDASD');
		$.ajax({
			type: "POST",
			url: window.location.pathname + '/class/login.php',
			data: $(this).serialize(),
			success: function(data) {
				if (data === 'Login') {
					alert('login succ');
					//window.location = '/user-page.php';
				}
				else {
					alert('Invalid Credentials');
				}
			}
		});
	});
});