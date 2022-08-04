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
        <li><a href="/backend">Zur&uuml;ck zum Dashboard</a></li>
        <li><a href="/backend/list?page=category">Zur&uuml;ck zur Kategorie</a></li>
    </ul>
</header>
<h1>{$title}</h1>
{if isset($subtitle)}
    <h2>{$subtitle}</h2>
{/if}
<div class="category-data">
    {if $create}
        {$active = false}
    {else}
        {$id = $category->id}
        {$name = $category->name}
        {$active = $category->active}
    {/if}
    <form action="/backend/profile?action=create&page=category" method="post">
        {if isset($id)}<input type="hidden" name="category[id]" value="{$id}" />{/if}
        <div class="profile-category--name">
            <label for="name">name</label>
            {if isset($name)}
                <span>{$name}</span>
            {else}
                <input type="text" id="name" name="category[name]" value="" />
            {/if}
        </div>
        {if $active}
            <div class="profile-category--active">
                <input type="hidden" id="active" name="category[active]" value="{$active}" />
                <label for="active">active</label>
                <span>Aktiv</span>
            </div>
        {/if}
        {if $create}<button type="submit">Speichern</button>{/if}
    </form>
</div>
</body>
</html>