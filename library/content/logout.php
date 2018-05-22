<form id="logoutForm" method="post" class="form-inline ">
    <div class="form-group row">
        <label id="loggedInUser" for="logout">
            <?php
            require_once '../class/User.php';
            session_start();
            if(isset($_SESSION['login'])) {
                echo $_SESSION['login']->username;
            }
            ?>
        </label>
        <br/>


        <button id="logout" class="btn btn-default col-sm-5 ml-2">Logout</button>
    </div>


</form>

<script>

	$(document).ready(function() {
		$('#logoutForm').submit(function(e) {
			e.preventDefault();
			logout($(this));
		});
	});

</script>