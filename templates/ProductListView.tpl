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
        {foreach item=product from=$products}
            <li>
                <a href="/backend/profile?page=product&id={$product->id}">{$product->name}</a>
                <a href="/backend/list?action=delete&page=product&id={$product->id}">Delete</a>
            </li>
        {/foreach}
        <br/>
        <a class="btn btn-block" href="/backend/profile?page=product&create=1">Neues Produkt</a>
    </ul>
</div>
</body>
</html>