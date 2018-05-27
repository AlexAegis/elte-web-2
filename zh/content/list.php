<?php session_start();
if (isset($_SESSION['login'])) { ?>
    <h1 class="display-3 mb-4">Books</h1>
    <table id="book" class="display mdl-data-table noBorderSpacing w-100">
        <thead>
        <tr>
            <th class="hidden">id</th>
            <th>author</th>
            <th>title</th>
            <th>category</th>
            <th>read</th>
            <th>remove</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    <script>
		$(document).ready(function () {
			let table = $('#book')
			table.dataTable({
				pagingType: 'numbers',
				lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, 'All']],
				displayStart: getParam('number') ? (parseInt(getParam('number')) - 1) * 5 : 1,
				pageLength: 5,
				processing: true,
				serverSide: true,
				ajax: 'class/bookTableQuery.php',
				order: [[2, 'asc']],
				columnDefs: [
					{
						targets: [1, 2, 3, 4],
						className: 'mdl-data-table__cell--non-numeric'
					},
					{
						targets: [0],
						visible: false,
						searchable: false
					},
					{
						targets: [4],
						searchable: false
					},
					{
						targets: [5],
						searchable: false,
                        orderable: false
					}
				],
				drawCallback: function (settings) {
					console.log(settings)
					setParam('number', (settings._iDisplayStart / settings._iDisplayLength) + 1) // reflects the selected page on the url
					if (settings.iDraw > 1) {
						let page = getParam('page')
						let number = getParam('number')
						console.log('page: ' + page + ' number: ' + number)
						removeParam()
						setParam('page', page)
						setParam('number', number)
						//removeParam('prevId') // is not working so this is a workaround
					}
				},
				createdRow: function (row, data, index) {
					let column = 4
					let rowValue = data[column]
					$('td', row).eq(column - 1).html('<div class="' + ((rowValue === null ? '0' : rowValue) === '1' ? 'far fa-check-circle' : 'far fa-circle') + '" ></div>') // added an offset because of the hidden column
					if (getParam('id') && data[0] === getParam('id')) {
						$(row).addClass('newRow')
					}
					if (getParam('prevId') && data[0] === getParam('prevId')) {
						$(row).addClass('removedFromBelow')
					}
					$('td', row).eq(column).html('<a class="btn deleteButton"><i class="far fa-trash-alt"></i></a>');
				},

			})
			$('#book tbody').on('click', 'td:not(:last-child)', function () {
				navigateBookPage(table.DataTable().row(this).data()[0])
			})
			$('#book tbody').on('click', 'tr .deleteButton', function () {
				removeBook($('#book').DataTable().row($(this).parent()).data()[0])
			})
		})
    </script>
<?php } else { ?>
    <p>Please log in to access this feature!</p>
<?php } ?>