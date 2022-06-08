<?php
declare(strict_types=1);

namespace View;

class FrontController
{
    private static string $layout = 'default';
    private static string $page = 'home';

    private static array $contentList = array(
        'home' => '<h2>Welcome</h2>'
    );

    public static function currentLayout(): string
    {
        return self::$layout;
    }

    public static function activePage(): string
    {
        if (self::$page === 'home') {
            self::$page = ROOT_PATH . '/src/View/Resources/Templates/home.php';
        }
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
        $content = explode(';', $content);
        switch ($category) {
            case 'category':
                self::$contentList['category'] = '<h2>Kategorie</h2><ul class="content">';
                foreach ($content as $str) {
                    self::$contentList['category'] .= "<li>$str</li>";
                }
                self::$contentList['category'] .= '</ul>';
                break;

            case 'detail':
                self::$contentList['details'] = '<h2>Produktdetails</h2><ul class="content">';
                foreach ($content as $str) {
                    self::$contentList['details'] .= "<li>$str</li>";
                }
                self::$contentList['details'] .= '</ul>';
                break;
        }
    }
}