<?php
$szin = 'ffff00';
if (isset($_GET['szin'])) {
    $szin = $_GET['szin'];
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Gyakorlat 8</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script>
</head>
<body style="background-color: #<?php echo $szin; ?>">
    <a href="<?php echo $_SERVER['PHP_SELF']; ?>?szin=0000ff">Kek</a>
    <a href="?szin=ff0000">Piros</a>
    <a href="?szin=ffff00">Sarga</a>
    <form action="szin.php" method="get">
        <input type="text" name="szin">
        <input type="submit">
    </form>
</body>
</html>