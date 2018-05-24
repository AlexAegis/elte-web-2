<?php session_start();
if (isset($_SESSION['login'])) { ?>
    <div id="books">
    </div>

    <div id="staticRow" class="row">
        <div class="col-sm-1">
            1.
        </div>
        <div class="col-sm-4">
            Holy lord fuck no
        </div>
        <div class="col-sm-4">
            - Abathur Roman
        </div>
        <div class="col-sm-2">
            1999
        </div>
        <div class="col-sm-1">
            C
        </div>
    </div>

    <script type="text/javascript">
		$(document).ready(function () {
			get($('#books'), 'bookController.php', 'listBooks', 'book', booksToList);
		});
    </script>
<?php } else { ?>
    <p>Please log in to access this feature!</p>
<?php } ?>