<form id="registrationForm" method="post">
    <h2>Registration</h2>
    <input id="registrationMode" hidden>
    <label id="registrationNameLabel" for="name">Name:</label>
    <input id="registrationName" name="name" type="text" placeholder="Enter your name" required/>
    <br/>
    <label id="registrationEmailLabel" for="email">E-mail:</label>
    <input id="registrationEmail" name="username" type="email" placeholder="Enter email" required/>
    <br/>
    <label id="registrationPasswordLabel" for="password">Password:</label>
    <input id="registrationPassword" name="password" type="password" placeholder="Enter password" required/>
    <br/>
    <button id="register" type="submit" onclick="$('#registrationMode').val('register')">Register</button>
    <h6 id="registrationMessage" class="error"></h6>
</form>
<script>

	$(document).ready(function() {
		$('#registrationForm').submit(function(e) {
			e.preventDefault();
			userController($(this), $('#registrationMode').val());
		});
	});

</script>