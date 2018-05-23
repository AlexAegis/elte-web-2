<?php session_start();
if (isset($_SESSION['login'])) { ?>
    <form>
        lol
    </form>
<?php } else { ?>
    <p>log in to access this feature!</p>
<?php } ?>