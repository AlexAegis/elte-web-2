<form id="loginForm" method="post">
    <input id="mode" type="hidden">
    <label id="emailLabel" for="email">E-mail:</label>
    <input id="email" name="username" type="email" placeholder="Enter email" required/>
    <label id="passwordLabel" for="password">Password:</label>
    <input id="password" name="password" type="password" placeholder="Enter password" required/>
    <button id="login" type="submit" onclick="$('#mode').val('login')">Login</button>
    <button id="navigateRegistration" type="submit" formnovalidate onclick="$('#mode').val('registrationStart')">Register</button>
    <h6 id="loginMessage" class="error"></h6>
</form>

<script>
	$(document).ready(function() {
		$('#loginForm').submit(function(e) {
			e.preventDefault();
			userController($(this), $('#mode').val());
		});
	});

</script>