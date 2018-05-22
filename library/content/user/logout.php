<form id="logoutForm" method="post" class="form-inline my-2 my-lg-0" action="../../index.php">

        <label id="loggedInUser" class="text-white control-label">
            <?php
            require_once '../../class/User.php';
            session_start();
            if(isset($_SESSION['login'])) {
                echo $_SESSION['login']->username;
            }
            ?>
        </label>
        <button id="logout" class="btn btn-outline-secondary form-control my-2 my-sm-0 ml-2">Logout</button>

</form>


<script type="text/javascript">

	$(document).ready(function() {
		$('#logoutForm').submit(function(e) {
			e.preventDefault();
			logout($(this));
		});
	});

</script>