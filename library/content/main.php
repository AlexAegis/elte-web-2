<?php session_start();
if (isset($_SESSION['login'])) { ?>
    <h1 class="display-3 mb-4">Books</h1>
    <table class="display" id="book" style="width:100%">
        <thead>
        <tr>
            <th>author</th>
            <th>title</th>
            <th>category</th>
            <th>read</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    <script>
        $(document).ready(function() {
	        $('#book').dataTable({
				scrollX: true,
				pagingType: "numbers",
				lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
				pageLength: 5,
				processing: true,
				serverSide: true,
				ajax: "class/datatable/book.php",
		        createdRow: function(row, data, index) {
					let column = 3;
			        let rowValue = data[column];
                    $('td', row).eq(column).html('<div class="' + ((rowValue === null ? '0' : rowValue) === '1' ? 'far fa-check-circle' : 'far fa-circle') + '" ></div>');
		        }
			} );
		});
    </script>
<?php } else { ?>
    <p>Please log in to access this feature!</p>
<?php } ?>