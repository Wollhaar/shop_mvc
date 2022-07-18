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
<p>
    <ul>
    {if $activeCategories}
        {foreach item=category from=$categories}
            <li><span>{$category->name}</span><a href="/backend/list?page=categories&delete={$category->id}">Delete</a></li>
        {/foreach}
        <br/>
        <a class="btn btn-block" href="/backend/profile?page=category&create=1">Neue Kategorie</a>
    {elseif $activeProducts}
        {foreach item=product from=$products}
            <li>
                <a href="/backend/profile?page=product&id={$product->id}">{$product->name}</a>
                <a href="/backend/list?page=products&delete={$product->id}">Delete</a>
            </li>
        {/foreach}
        <br/>
        <a class="btn btn-block" href="/backend/profile?page=product&create=1">Neues Produkt</a>
    {elseif $activeUsers}
        {foreach item=user from=$users}
            <li>
                <a href="/backend/profile?page=user&id={$user->id}">{$user->username}: {$user->lastname}, {$user->firstname}</a>
                <a href="/backend/list?page=users&delete={$user->id}">Delete</a>
            </li>
        {/foreach}
        <br/>
        <a class="btn btn-block" href="/backend/profile?page=user&create=1">Neuer User</a>
    {else}
        <span>Keine Liste ausgew&auml;hlt</span>
    {/if}
    </ul>
</p>
</body>
</html>