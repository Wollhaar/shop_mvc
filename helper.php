<?php declare(strict_types=1);

function inputHTML(string $content, string $template, $mark):void
{
    $file_content = file_get_contents($template);
    $file_content = str_replace($mark, $content, $file_content);
    file_put_contents($template, $file_content);
}