<!doctype html>
<html lang="en">
    <head>
        <title>Library</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="description" content="Library application">
        <meta name="author" content="AlexAegis">
        <link rel="icon" href="resources/book.png">

        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="css/library.css">

    </head>
    <body>
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <a class="navbar-brand" onclick="init()">Library</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div id="navbar" class="collapse navbar-collapse">
                <div id="navigation" class="mr-auto"></div>
                <div id="user"></div>
            </div>
        </nav>
        <main role="main">
            <div class="jumbotron">
                <div id="content" class="container">

                </div>
            </div>
            <div id="subContent" class="container">
                Woohoo
            </div>
        </main>
        <footer class="container">
            <p>&copy; AlexAegis 2018</p>
        </footer>
        <script src="js/vendor/modernizr-3.5.0.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"
                integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-3.2.1.min.js"><\/script>');</script>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/plugins.js"></script>
        <script src="js/utility.js"></script>
        <script type="text/javascript" src="js/main.js"></script>
    </body>
</html>