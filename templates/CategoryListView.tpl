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
    <ul><li><a href="/backend">Zur&uuml;ck</a></li></ul>
</header>
<h1>{$title}</h1>
<div>
    <ul>
        {foreach item=category from=$categories}
            <li><span>{$category->name}</span><a href="/backend/list?action=delete&page=category&id={$category->id}">Delete</a></li>
        {/foreach}
        <br/>
        <a class="btn btn-block" href="/backend/profile?page=category&create=1">Neue Kategorie</a>
    </ul>
</div>
</body>
</html>