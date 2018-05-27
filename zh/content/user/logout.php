<?php session_start();
if (isset($_SESSION['login'])) { ?>
    <form id="logoutForm" method="post" class="form-inline my-2 my-lg-0" action="../../index.php">
        <label id="loggedInUser" class="text-white control-label"></label>
        <button id="logout"
                onclick="$('.navbar-collapse').collapse('hide');"
                class="btn btn-outline-secondary form-control my-2 my-sm-0 ml-2">Logout
        </button>
    </form>
    <script type="text/javascript">
		$(document).ready(function () {
			$('#loggedInUser').set('session', 'loggedInUser')
			$('#logoutForm').submit(function (e) {
				e.preventDefault()
				logout($(this))
			})
		})
    </script>
<?php } ?>