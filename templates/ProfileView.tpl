<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{$title}</title>
</head>
<body>
{if $active == 'product'}
    {$backLink = 'products'}
{elseif $active == 'category'}
    {$backLink = 'categories'}
{elseif $active == 'user'}
    {$backLink = 'users'}
{/if}
<header>
    <ul>
        <li><a href="/backend">Zur&uuml;ck zum Dashboard</a></li>
        <li><a href="/backend/list?page={$backLink}">Zur&uuml;ck zur Kategorie</a></li>
    </ul>
</header>
<h1>{$title}</h1>
{if isset($subtitle)}
<h2>{$subtitle}</h2>
{/if}
<div class="profile-data">
{if $active == 'product'}
    {if isset($product)}
        {$id = $product->id}
        {$name = $product->name}
        {$size = $product->size}
        {$selected = $product->category == $category->name}
        {$price = $product->price}
        {$amount = $product->amount}
        {$active = $product->active}
    {else}
        {$id = 0}
        {$name = ''}
        {$size = ''}
        {$selected = ''}
        {$price = 0}
        {$amount = 0}
        {$active = false}
    {/if}
    <form action="/backend/profile/{if isset($create)}create{else}save{/if}?page=product" method="post">
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
{elseif $active == 'category'}
    <form action="/backend/profile/create?page=category" method="post">
        <label for="name">Kategoriename</label>
        <input type="text" id="name" name="category[name]" />
        <button type="submit">Hinzuf&uuml;gen</button>
    </form>
{elseif $active == 'user'}
    {if isset($user)}
        {$id = $user->id}
        {$username = $user->username}
        {$firstname = $user->firstname}
        {$lastname = $user->lastname}
        {$birthday = $user->birthday|date_format:"%Y-%m-%d"}
        {$active = $user->active}
    {else}
        {$id = 0}
        {$username = ''}
        {$firstname = ''}
        {$lastname = ''}
        {$birthday = 0}
        {$active = false}
    {/if}
    <form action="/backend/profile/{if $create}create{else}save{/if}?page=user" method="post">
        <input type="hidden" name="user[id]" value="{$id}" />
        <div class="profile-user--username">
            <label for="username">username</label>
            <input type="text" id="username" name="user[username]" value="{$username}" />
        </div>
        <div class="profile-user--password">
            <label for="password">password</label>
            <input type="password" id="password" name="user[password]" />
        </div>
        <div class="profile-user--firstname">
            <label for="firstname">firstname</label>
            <input type="text" id="firstname" name="user[firstname]" value="{$firstname}" />
        </div>
        <div class="profile-user--lastname">
            <label for="lastname">lastname</label>
            <input type="text" id="lastname" name="user[lastname]" value="{$lastname}" />
        </div>
        {if empty($create)}
        <div class="profile-user--created">
            <input type="hidden" name="user[created]" value="{$user->created|date_format:"%Y-%m-%d"}">
            <label for="created">created</label>
            <span type="date" id="created">{$user->created|date_format:"%D"}</span>
        </div>
        <div class="profile-user--updated">
            <label for="updated">updated</label>
            <span id="updated">{$user->updated|date_format:"%D"}</span>
        </div>
        {/if}
        <div class="profile-user--birthday">
            <label for="birthday">birthday</label>
            <input type="date" id="birthday" name="user[birthday]" value="{$birthday}" />
        </div>
        {if $active}
        <div class="profile-user--active">
            <input type="hidden" id="active" name="user[active]" value="{$active}" />
            <label for="active">active</label>
            <span>Aktiv</span>
        </div>
        {/if}
        <button type="submit">{if $create}Hinzuf&uuml;{else}Speichern{/if}</button>
    </form>
{/if}
</div>
</body>
</html>