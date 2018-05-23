<form id="registrationForm" method="post" class="form-horizontal my-2 my-lg-0 row" action="../../index.php">
    <h1 class="display-3 col-12">Registration</h1>
    <div class="col-sm-8 col-md-8 col-lg-8 col-12  form-group">
        <label id="registrationNameLabel"
               for="name"
               class="control-label mr-1">
            Name:
        </label>
        <input id="registrationName"
               name="name"
               type="text"
               placeholder="Enter your name"
               class="form-control"
               required/>
        <label id="registrationEmailLabel"
               for="email"
               class="control-label mr-1">
            E-mail:
        </label>
        <input id="registrationEmail"
               name="email"
               type="email"
               placeholder="Enter your email"
               class="form-control"
               required/>

        <label id="registrationPasswordLabel"
               for="password"
               class="control-label mr-1">
            Password:
        </label>
        <input id="registrationPassword"
               name="password"
               type="password"
               placeholder="Enter password"
               class="form-control"
               required/>
    </div>
    <div class="mt-4 col-sm-4 col-md-4 col-lg-4 col-12">
        <button id="register"
                class="form-control btn btn-primary mt-2 mr-1"
                type="submit"
                onclick="$('#registrationMode').val('register')">
            Register
        </button>
    </div>
    <h6 id="registrationMessage" class="error"></h6>
    <input id="registrationMode" hidden>
</form>
<script>
	$(document).ready(function() {
		$('#registrationForm').submit(function(e) {
			e.preventDefault();
			$('#registrationName').removeClass('is-invalid');
			$('#registrationEmail').removeClass('is-invalid');
			console.log($(this).serializeArray());
			userController($(this), $('#registrationMode').val());
		});
	});
</script>