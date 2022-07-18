<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
</head>
<body>
<style>
    body {
        width: 100%;
    }
    body > p {
        width: 80%;
    }
    .username-field,
    .password-field {
        margin: auto 20px;
    }
</style>
<header>
    <ul>
        <li><a href="/?page=home">Home</a></li>
    </ul>
</header>
<h1>Backend Login</h1>
<p>
{if isset($authentication)}
    {$authUsername = $authentication.username}
    {if $authUsername}
        {$authPassword = $authentication.password}
    {/if}
{/if}
    <form action="/backend/login" method="post">
        <div class="username-field">
            {if isset($authUsername) && $authUsername == false}
                <span style="color:red;font-size: 0.7rem;display: block">Username does not exist</span>
            {/if}
            <label for="username">Username</label>
            <input type="text" id="username" name="username"/>
        </div>
        <div class="password-field">
            {if isset($authPassword) && $authPassword == false}
                <span style="color:red;font-size: 0.7rem;display: block">Password is false</span>
            {/if}
            <label for="password">Password</label>
            <input type="password" id="password" name="password"/>
        </div>
        <button type="submit">Anmelden</button>
    </form>
</p>
</body>
</html>