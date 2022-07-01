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
<b>Kategorie: {if isset($product.category)}{$product.category}{/if}</b>
<h1>Produktdetailseite:{if isset($product.name)} {$product.name}{/if}</h1>
<p>ArtikelId:{if isset($product.id)} {$product.id}{/if}</p>
<p>Gr&ouml;ße: {if isset($product.size)}{$product.size}{/if}</p>
<p>Preis: {if isset($product.price)}{$product.price} &euro;{/if}</p>
<p>Vorrat: {if isset($product.amount)}{$product.amount}{/if}</p>
</body>
</html>