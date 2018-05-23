<?php session_start();
if (isset($_SESSION['login'])) { ?>
    <div id="books">
    </div>

    <script type="text/javascript">
		$(document).ready(function () {
			get($('#books'), 'bookController.php', 'listBooks', 'book', booksToList);
		});
    </script>
<?php } else { ?>
    <p>Please log in to access this feature!</p>
<?php } ?>