<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Test</title>
</head>
<body>
<header>
    <ul>
        <li><a href="?page=home">Home</a></li>
        <li><a href="?page=category">Kategorie</a></li>
    </ul>
</header>
<h1>Shop</h1>
<p>
{foreach key=id item=category from=$output}
    <a href="?page=category&id={$id}">{$category}</a><br/>
{/foreach}
</p>
</body>
</html>