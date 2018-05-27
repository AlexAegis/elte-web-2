<form id="registrationForm" method="post" class="form-inline my-2 my-lg-0 row" action="../../index.php">
    <h1 class="display-3 col-12">Registration</h1>
    <div class="col-sm-8 col-md-8 col-lg-8 col-12  form-group">
        <div class="form-group row col-12 mt-2">
            <label id="registrationNameLabel" for="registrationName" class="control-label mr-4 col-2">Name</label>
            <input id="registrationName" name="name" type="text" value="" placeholder="Enter name"
                   class="form-control col-6"/>
            <label id="registrationNameError" for="registrationName" class="error mdl-color-text--red ml-1 col-2"></label>
        </div>
        <div class="form-group row col-12 mt-2">
            <label id="registrationEmailLabel" for="registrationEmail" class="control-label mr-4 col-2">E-mail</label>
            <input id="registrationEmail" name="email" type="text" value="" placeholder="Enter email" class="form-control col-6"/>
            <label id="registrationEmailError" for="registrationEmail" class="error mdl-color-text--red ml-1 col-2"></label>
        </div>
        <div class="form-group row col-12 mt-2">
            <label id="registrationPasswordLabel" for="registrationPassword" class="control-label mr-4 col-2">Password</label>
            <input id="registrationPassword" name="password" type="text" value="" placeholder="Enter password" class="form-control col-6"/>
            <label id="registrationPasswordError" for="registrationPassword" class="error mdl-color-text--red ml-1 col-2"></label>
        </div>
    </div>
    <div class="form-group row mt-4 col-sm-4 col-md-4 col-lg-4 col-12">
        <button id="register" class="form-control btn btn-primary mt-2 mr-1" type="submit">Register</button>
    </div>
</form>
<script>
	$(document).ready(function () {
		$('#registrationForm').submit(function (e) {
			e.preventDefault()
            let form = $('#registrationForm');
			form.find('input').removeClass('is-invalid')
			form.find('.error').html('')
			formController($(this), 'user', 'register', null, function (response) {
				loadWelcomePage(() => {
					$('#email').val(response.email)
					$('#password').val(response.password)
					$('#login').focus()
				})
			})
		})
	})
</script>