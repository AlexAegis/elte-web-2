<?php
    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'aqv5ak');
    define('DB_PASSWORD', 'aqv5ak');
    define('DB_DATABASE', 'wf2_aqv5ak');
    $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
    // check connection
    if ($db -> connect_error) {
        die("Connection failed: " . $db -> connect_error);
    }