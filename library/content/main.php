<?php session_start();
if (isset($_SESSION['login'])) { ?>
    <div id="books">
    </div>

    <table class="display" id="example" style="width:100%">
        <thead>
        <tr>
            <th>id</th>
            <th>email</th>
            <th>name</th>
        </tr>
        </thead>
    </table>

    <script type="text/javascript">

        $(document).ready(function() {
			$('#example-detail').dataTable({
				scrollX: true,
				pagingType: "numbers",
				processing: true,
				serverSide: true,
				ajax: "../class/bookController.php"
			} );
		} );
    </script>
<?php } else { ?>
    <p>Please log in to access this feature!</p>
<?php } ?>