<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{$title}</title>
</head>
<body>
<h1>{$title}</h1>
<h2>Hello, {$user->firstname}</h2>
<ul>
    <li><a href="/backend?page=dashboard">Übersicht</a></li>
    <li><a href="/backend/list?page=category">Kategorien</a></li>
    <li><a href="/backend/list?page=product">Produkte</a></li>
    <li><a href="/backend/list?page=user">Userliste</a></li>
    <li><a href="/backend?page=logout">Logout</a></li>
</ul>
</body>
</html>