<?php session_start();
if (isset($_SESSION['login'])) { ?>
    <ul class="navbar-nav">
        <li class="nav-item pointer">
            <a id="listPage" class="nav-link" onclick="navigateListPage()">List Books</i></a>
        </li>
        <li class="nav-item pointer">
            <a id="createPage" class="nav-link" onclick="navigateBookPage()"><i class="fas fa-plus"></i> Add Book</a>
        </li>
    </ul>
<?php } ?>