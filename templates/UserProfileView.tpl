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
    {$email = ''}
    {$firstname = ''}
    {$lastname = ''}
    {$birthday = 0}
    {$role = ''}
    {$active = false}
{else}
    {$id = $user->id}
    {$username = $user->username}
    {$email = $user->email}
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
        <div class="profile-user--email">
            <label for="email">email</label>
            <input type="text" id="email" name="user[email]" value="{$email}" />
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
            <div class="profile-user--updated">
                <label for="updated">updated</label>
                <span id="updated">{$user->updated|date_format:"%D"}</span>
            </div>
        {/if}
        <div class="profile-user--birthday">
            <label for="birthday">birthday</label>
            <input type="date" id="birthday" name="user[birthday]" value="{$birthday}" />
        </div>
        <div class="profile-user--role">
            <label for="role">role</label>
            <select type="text" id="role" name="user[role]">
                <option value="standard" {if $role === 'standard'}selected{/if}>standard</option>
                <option value="admin" {if $role === 'admin'}selected{/if}>admin</option>
            </select>
        </div>
        {if $active}
            <div class="profile-user--active">
                <input type="hidden" id="active" name="user[active]" value="{$active}" />
                <label for="active">active</label>
                <span>Aktiv</span>
            </div>
        {/if}
        <button type="submit">{if $create}Hinzuf&uuml;gen{else}Speichern{/if}</button>
    </form>
</div>
</body>
</html>