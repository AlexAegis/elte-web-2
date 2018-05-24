<?php session_start();
if (isset($_SESSION['login'])) { ?>
    <table class="display" id="book" style="width:100%">
        <thead>
        <tr>
            <th>author</th>
            <th>title</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    <script>
        $(document).ready(function() {
	        //$.noConflict(true);

	        let bk = $('#book');
			bk.dataTable({
				scrollX: true,
				pagingType: "numbers",
				lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
				pageLength: 5,
				processing: true,
				serverSide: true,
				ajax: "class/bookController.php"
			} );
		} );
    </script>
<?php } else { ?>
    <p>Please log in to access this feature!</p>
<?php } ?>