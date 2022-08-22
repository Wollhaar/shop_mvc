<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{$title}</title>
</head>
<body>
<h1>{$title}</h1>
<h2>{$subtitle}</h2>
<ul>
    <li>{$user-role}</li>
    <li><a href="/backend">Übersicht</a></li>
    {if $user-role === 'admin' || $user-role === 'root'}
        <li><a href="/backend/list?page=category">Kategorien</a></li>
        <li><a href="/backend/list?page=product">Produkte</a></li>
        {if $user-role === 'root'}
            <li><a href="/backend/list?page=user">Userliste</a></li>
        {/if}
    {/if}
    <li><a href="/backend?page=logout">Logout</a></li>
</ul>
</body>
</html>