<form id="loginForm" method="post" class="form-inline my-2 my-lg-0">
    <div class="form-group">
        <label id="emailLabel"
               for="email"
               class="text-white-50 control-label mr-1">
            E-mail:
        </label>
        <input id="email"
               name="email"
               type="email"
               placeholder="Enter email"
               class="form-control"/>
    </div>
    <div class="form-group">
        <label id="passwordLabel"
               for="password"
               class="text-white-50 control-label mr-1 ml-1">
            Password:
        </label>
        <input id="password"
               name="password"
               type="password"
               placeholder="Enter password"
               class="form-control"/>
    </div>
    <button id="login"
            type="submit"
            class="form-control btn btn-outline-success my-2 my-sm-0 ml-2">
        Login
    </button>
    <button id="navigateRegistration"
            type="button"
            class="form-control btn btn-outline-light my-2 my-sm-0 ml-2"
            onclick="navigateRegistration();">
        Register
    </button>
</form>

<script type="text/javascript">
	$(document).ready(function () {
		$('#loginForm').submit(function (e) {
			e.preventDefault()
			$('#loginForm input').removeClass('is-invalid')
			formController($(this), 'user', 'login', null, navigateListPage(response))
		})
	})

</script>