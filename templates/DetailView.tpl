<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Test{if isset($category)} | {$category}{/if}{if isset($name)} | {$name}{/if}</title>
</head>
<body>
<header style="padding-bottom:20px">
    <ul style="list-style-type:none;display:inline-block;">
        <li style="inline"><a href="?page=home">Home</a></li>
        <li style="inline"><a href="?page=category">Kategorie</a></li>
    </ul>
</header>
<b>Kategorie: {if isset($category)}{$category}{/if}</b>
<h1>Produktdetailseite:{if isset($name)} {$name}{/if}</h1>
<p>ArtikelId:{if isset($id)} {$id}{/if}</p>
<p>Gr&ouml;ße: {if isset($size)}{$size}{/if}</p>
<p>Preis: {if isset($price)}{$price} &euro;{/if}</p>
<p>Vorrat: {if isset($amount)}{$amount}{/if}</p>
</body>
</html>