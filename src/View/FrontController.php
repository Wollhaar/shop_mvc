<?php
declare(strict_types=1);

namespace View;

class FrontController
{
    private static string $layout = 'default';
    private static string $page = 'home';

    private static array $contentList = array();

    public static function currentLayout(): string
    {
        return self::$layout;
    }

    public static function activePage(): string
    {
        return self::$page;
    }

    public static function setLayout(string $layout): void
    {
        self::$layout = $layout;
    }

    public static function setPage(string $page): void
    {
        self::$page = $page;
    }

    public static function setContent(string $content, string $category):void
    {
        self::$contentList[$category] = $content;
    }

    public static function callContent(string $category):string
    {
        return self::$contentList[$category];
    }

    public static function build(string $content, string $category):void
    {
        switch ($category) {
            case 'category':
                self::$contentList['category'] = '<h2>Category</h2><div class="content">' . $content . '</div>';
                break;

            case 'detail':
                self::$contentList['details'] = '<h2>Produktdetails</h2><div class="content">' . $content . '</div>';
                break;

            default:
                self::$contentList['home'] = '<h2>Welcome</h2>';
        }
    }
}