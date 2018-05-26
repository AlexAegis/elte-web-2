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
        <link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="resources/datatables/datatables.min.css"/>
        <link rel="stylesheet" type="text/css" href="css/library.css">

        <script type="text/javascript" src="js/vendor/modernizr-3.5.0.min.js"></script>
        <script type="text/javascript" src="js/vendor/jquery-3.2.1.min.js"></script>
        <script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/plugins.js"></script>
        <script type="text/javascript" src="js/utility.js"></script>
        <script type="text/javascript" src="resources/datatables/datatables.min.js"></script>
        <script type="text/javascript" src="js/main.js"></script>
    </head>
    <body>
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <div class="navbar-btn noselect" onclick="init()">
                <a class="navbar-brand text-white text-center" role="link">Library</a>
            </div>

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
                <div id="content" class="container pt-4 pl-1 pr-1 pb-1">

                </div>
            </div>
            <div id="subContent" class="container">
                Woohoo
            </div>
        </main>
        <footer class="container">
            <p><a href="https://github.com/AlexAegis/" target="_blank" role="link" class="text-black-50">&copy; AlexAegis 2018</a></p>
        </footer>
    </body>
</html>