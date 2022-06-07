<!doctype html>
<html>
<head>
<!--    <link rel="stylesheet" type="text/css" href="/vendor/twbs/bootstrap/dist/css/bootstrap.css">-->
<!--    <script type="text/javascript" src="/vendor/twbs/bootstrap/dist/js/bootstrap.js"></script>-->
</head>
<body>
<header class="header">
    <div class="top-bar"><div></div></div>
    <div class="header-menu">
        <div class="header-link-menu">
            <ul class="link-menu">
                <li><a href="?page=home">Home</a></li>
                <li><a href="?page=detail">Details</a></li>
<!--                <li><a href="?page=list">Listing</a></li>-->
            </ul>
        </div>
    </div>
</header>
<div class="main">
    <?php
    include_once View\FrontController::activePage();
    ?>
</div>
</body>
</html>

