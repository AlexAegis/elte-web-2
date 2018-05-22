<form id="loginForm" method="post" class="form-inline my-2 my-lg-0" action="content/main.php">
    <label id="emailLabel" for="email" class="control-label col-sm-4">E-mail:</label>
    <input id="email" name="username" type="email" placeholder="Enter email" class="form-control col-sm-8" required/>
    <label id="passwordLabel" for="password" class="control-label col-sm-4">Password:</label>
    <input id="password" name="password" type="password" placeholder="Enter password" class="form-control col-sm-8" required/>

    <button id="login"
            type="submit"
            class="form-control btn btn-outline-success col-sm-6 my-2 my-sm-0 ml-2"
            onclick="$('#mode').val('login')">
        Login
    </button>
    <button id="navigateRegistration"
            type="submit"
            formnovalidate
            class="form-control btn btn-outline-light col-sm-4 my-2 my-sm-0 ml-2"
            onclick="$('#mode').val('registrationStart')">
        Register
    </button>
    <input id="mode" type="hidden">
    <h6 id="loginMessage" class="error">sdgfg</h6>
</form>


<script>
	$(document).ready(function() {
		$('#loginForm').submit(function(e) {
			e.preventDefault();
			userController($(this), $('#mode').val());
		});
	});

</script>