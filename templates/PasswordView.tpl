<!doctype html>
<html>
<head></head>
<body>
<header>
    <ul>
        <li><a href="/backend">Zur&uuml;ck zum Dashboard</a></li>
        <li><a href="/backend/list?page=user">Zur&uuml;ck zur Kategorie</a></li>
    </ul>
</header>
<h1>{$title}</h1>
{if isset($subtitle)}
    <h2>{$subtitle}</h2>
{/if}
<div>
    {if $create}
        {$username = ''}
        {$firstname = ''}
        {$lastname = ''}
        {$birthday = 0}
        {$role = ''}
        {$active = false}
    {else}
        {$id = $user->id}
        {$username = $user->username}
        {$firstname = $user->firstname}
        {$lastname = $user->lastname}
        {$birthday = $user->birthday|date_format:"%Y-%m-%d"}
        {$role = $user->role}
        {$active = $user->active}
    {/if}
    <form action="/backend/profile?action={if $create}create{else}save{/if}&page=user" method="post">
        {if isset($id)}<input type="hidden" name="user[id]" value="{$id}" />{/if}
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
        {if !$create}
            <div class="profile-user--created">
                <input type="hidden" name="user[created]" value="{$user->created|date_format:"%Y-%m-%d"}">
                <label for="created">created</label>
                <span type="date" id="created">{$user->created|date_format:"%D"}</span>
            </div>
        {/if}
        <button type="submit">anfragen</button>
    </form>
</div>
</body>
</html>