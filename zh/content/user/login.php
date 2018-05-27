<form id="loginForm" method="post" class="form-inline my-2 my-lg-0">
    <div class="form-group col-12">
        <label id="emailLabel" for="email" class="text-white-50 control-label mr-1">E-mail</label>
        <div class="flex-column">
            <input id="email" name="email" placeholder="Enter email" class="form-control "/>
            <label id="emailError" for="email"
                   class="  error labelBelow  position-absolute mdl-color-text--red ml-1 mb-auto"> </label>
        </div>
        <label id="passwordLabel" for="password" class="text-white-50 control-label mr-1 ml-1">Password</label>
        <div class="flex-column mb-4 mb-sm-0">
            <input id="password" name="password" type="password" placeholder="Enter password" class="form-control"/>
            <label id="passwordError" for="email"
                   class="error labelBelow  position-absolute mdl-color-text--red ml-1 d-lg-block"></label>
        </div>
        <button id="login"
                type="submit"
                class="form-control btn btn-outline-success my-2 my-sm-0 ml-2 pt-2">
            Login
        </button>
        <button id="navigateRegistration"
                type="button"
                class="form-control btn btn-outline-light my-2 my-sm-0 ml-2"
                onclick="navReg()">Register
        </button>

    </div>

</form>

<script type="text/javascript">
	$(document).ready(function () {
		$('#loginForm').controller('user', 'login', function (response) {
			navigateListPage(response)
		})
	})

	function navReg() { // idk why i need this "alias"
		navigateRegistration()
	}
</script>