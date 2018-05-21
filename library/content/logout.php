<form id="logoutForm" method="post">
    <div id="loggedInUser">

    <?php
    require_once '../class/User.php';
    session_start();
    if(isset($_SESSION['login'])) {
        echo $_SESSION['login']->username;
    }
    ?>

    </div>
    <button id="logout">Logout</button>
</form>

<script>

	$(document).ready(function() {
		$('#logoutForm').submit(function(e) {
			e.preventDefault();
			logout($(this));
		});
	});

</script>