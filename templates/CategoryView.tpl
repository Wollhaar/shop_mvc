<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Test
        {if isset($title) }
            | {$title}
        {/if}
    </title>
</head>
<body>
<header>
    <ul>
        <li><a href="?page=home">Home</a></li>
        <li><a href="?page=category">Kategorie</a></li>
    </ul>
</header>
<h1>Kategorie
    {if isset($title) }
        - {$title}
    {/if}
</h1>
<p>
{if $activeCategory}
    {foreach key=id item=detail from=$build}
        <a href="?page=detail&id={$id}">{$detail}</a><br/>
    {/foreach}
{else}
    {foreach key=id item=category from=$build}
        <a href="?page=category&id={$id}">{$category->name}</a><br/>
    {/foreach}
{/if}
</p>
</body>
</html>