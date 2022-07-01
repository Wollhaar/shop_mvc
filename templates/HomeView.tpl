<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{$title}</title>
</head>
<body>
<header>
    <ul>
        <li><a href="?page=home">Home</a></li>
        <li><a href="?page=category">Kategorie</a></li>
    </ul>
</header>
<h1>{$title}</h1>
<p>
{foreach item=category from=$categories}
    <a href="?page=category&id={$id}">{$category['name']}</a><br/>
{/foreach}
</p>
</body>
</html>