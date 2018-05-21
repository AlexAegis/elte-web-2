<form id="logoutForm" method="post">

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