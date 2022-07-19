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
        <li><a href="/backend/list?page=product">Zur&uuml;ck zur Kategorie</a></li>
    </ul>
</header>
<h1>{$title}</h1>
{if isset($subtitle)}
<h2>{$subtitle}</h2>
{/if}
<div class="profile-data">
{if $create}
    {$id = 0}
    {$name = ''}
    {$size = ''}
    {$selected = ''}
    {$price = 0}
    {$amount = 0}
    {$active = false}
{else}
    {$id = $product->id}
    {$name = $product->name}
    {$size = $product->size}
    {$selected = $product->category == $category->name}
    {$price = $product->price}
    {$amount = $product->amount}
    {$active = $product->active}
{/if}
    <form action="/backend/profile/{if $create}create{else}save{/if}?page=product" method="post">
        <input type="hidden" name="product[id]" value="{$id}" />
        <div class="profile-product--name">
            <label for="name">name</label>
            <input type="text" id="name" name="product[name]" value="{$name}" />
        </div>
        <div class="profile-product--size">
            <label for="size">size</label>
            <input type="text" id="size" name="product[size]" value="{$size}" />
        </div>
        <div class="profile-product--category">
            <label for="category">category</label>
            <select type="text" id="category" name="product[category]">
                {foreach item=category from=$categories}
                    <option value="{$category->id}"{if $selected == $category->name} selected{/if}>{$category->name}</option>
                {/foreach}
            </select>
        </div>
        <div class="profile-product--price">
            <label for="price">price</label>
            <input type="text" id="price" name="product[price]" value="{$price}" />
        </div>
        <div class="profile-product--amount">
            <label for="amount">amount</label>
            <input type="text" id="amount" name="product[amount]" value="{$amount}" />
        </div>
        {if $active}
            <div class="profile-user--active">
                <input type="hidden" id="active" name="user[active]" value="{$active}" />
                <label for="active">active</label>
                <span>Aktiv</span>
            </div>
        {/if}
        <button type="submit">Speichern</button>
    </form>
</div>
</body>
</html>