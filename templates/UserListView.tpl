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
        {foreach item=user from=$users}
            <li>
                <a href="/backend/profile?page=user&id={$user->id}">{$user->username}: {$user->lastname}, {$user->firstname}</a>
                <a href="/backend/delete?page=user&id={$user->id}">Delete</a>
            </li>
        {/foreach}
        <br/>
        <a class="btn btn-block" href="/backend/profile?page=user&create=1">Neuer User</a>
    </ul>
</div>
</body>
</html>