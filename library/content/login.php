<form id="loginForm" method="post" class="form-inline" action="main.php">
    <div class="row">
        <div class="form-group">
            <input id="mode" type="hidden">
            <label id="emailLabel" for="email" class="label control-label col-sm-4">E-mail:</label>
            <input id="email" name="username" type="email" placeholder="Enter email" class="form-control col-sm-8" required/>

        <div class="form-group">
            <label id="passwordLabel" for="password" class="control-label col-sm-4">Password:</label>
            <input id="password" name="password" type="password" placeholder="Enter password" class="form-control col-sm-8" required/>
        </div>
        <div class="form-group">
            <button id="login" type="submit" class="btn btn-primary col-sm-10 ml-2" onclick="$('#mode').val('login')">Login</button>
        </div>
        <div class="form-group">
            <button id="navigateRegistration" type="submit" formnovalidate class="btn btn-default col-sm-10 ml-2" onclick="$('#mode').val('registrationStart')">Register</button>
        </div>


        <h6 id="loginMessage" class="error">sdgfg</h6>
    </div>
</form>






<script>
	$(document).ready(function() {
		$('#loginForm').submit(function(e) {
			e.preventDefault();
			userController($(this), $('#mode').val());
		});
	});

</script>