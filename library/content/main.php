<?php session_start();
if (isset($_SESSION['login'])) { ?>
    <form>
        lol
    </form>
<?php } else { ?>
    <p>Please log in to access this feature!</p>
<?php } ?>