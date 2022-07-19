<!doctype html>
<html>
<head></head>
<body>
<div>
{if $create}
    {$id = 0}
    {$username = ''}
    {$firstname = ''}
    {$lastname = ''}
    {$birthday = 0}
    {$active = false}
{else}
    {$id = $user->id}
    {$username = $user->username}
    {$firstname = $user->firstname}
    {$lastname = $user->lastname}
    {$birthday = $user->birthday|date_format:"%Y-%m-%d"}
    {$active = $user->active}
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
        {if $active}
            <div class="profile-user--active">
                <input type="hidden" id="active" name="user[active]" value="{$active}" />
                <label for="active">active</label>
                <span>Aktiv</span>
            </div>
        {/if}
        <button type="submit">{if $create}Hinzuf&uuml;{else}Speichern{/if}</button>
    </form>
</div>
</body>
</html>