<?php session_start();
if (isset($_SESSION['login'])) { ?>
    <h1 class="display-3 mb-4">Books</h1>
    <table class="display mdl-data-table noBorderSpacing" id="book" style="width:100%">
        <thead>
            <tr>
                <th class="hidden">id</th>
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
        	let table = $('#book');

	        table.dataTable({
				pagingType: "numbers",
				lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
		        displayStart: getParam('number') ? parseInt(getParam('number')) - 1 : 0,
				pageLength: 5,
				processing: true,
				serverSide: true,
				ajax: "class/datatable/book.php",
		        order: [[ 2, 'asc' ]],

		        columnDefs: [
			        {
				        targets: [ 1, 2, 3, 4 ],
				        className: 'mdl-data-table__cell--non-numeric'
			        },
			        {
				        targets: [ 0 ],
				        visible: false,
				        searchable: false
			        },
			        {
				        targets: [ 4 ],
				        searchable: false
			        }
		        ],
		        createdRow: function(row, data, index) {
					let column = 3;
			        let rowValue = data[column];
			        //row.addClass('clickable');
                    $('td', row).eq(column).html('<div class="' + ((rowValue === null ? '0' : rowValue) === '1' ? 'far fa-check-circle' : 'far fa-circle') + '" ></div>');
		        }
			} );
	        let dataTable = table.DataTable();

	        $('#book tbody').on('click', 'tr', function () {
	        	navigateBookPage(dataTable.row(this).data()[0]);
	        } );
/*
	        dataTable.page(2);
	        dataTable.draw('page');*/
		});
    </script>
<?php } else { ?>
    <p>Please log in to access this feature!</p>
<?php } ?>