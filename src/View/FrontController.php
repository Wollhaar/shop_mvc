<?php
declare(strict_types=1);

namespace View;

use Controller\Shop\CategoryController;
use Controller\Shop\ProductController;
use Model\Shop\Category;

class FrontController
{
    private static string $layout = 'default';
    private static string $page = 'home';

    private static array $contentList = array(
        'home' => '<h2>Welcome</h2>',
        'category' => '<h2>Kategorie</h2><ul class="content">',
        'details' => '<h2>Produktdetails</h2><ul class="content">'
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

    public static function setDefaultCategory():void
    {
        $categories = new CategoryController();
        $products = new ProductController();

        self::$contentList['collection'] = [
            'category' => $categories->collection,
            'product' => $products->collection
        ];
    }

    public static function setContent(string $content, string $category):void
    {
        self::$contentList[$category] = $content;
    }

    public static function callContent(string $category):string
    {
        return self::$contentList[$category];
    }

    public static function build(string $content, string $page, bool $contentSet = false):void
    {
        $content = explode(';', $content);
        self::setDefaultCategory();
        
        switch ($page) {
            case 'category':
                if ($contentSet) {
                    foreach ($content as $str) {
                        self::$contentList['category'] .= "<li>$str</li>";
                    }
                }
                else {
                    foreach (self::$contentList['collection']['category'] as $category) {
                        self::$contentList['category'] .= "<li><a href='?page=category&id=" . $category->getId() . "'>" . $category->getName() . "</a></li>";
                    }
                }
                break;

            case 'detail':
                if ($contentSet) {
                    foreach ($content as $str) {
                        self::$contentList['details'] .= "<li>$str</li>";
                    }
                }
                else {
                    foreach (self::$contentList['collection']['product'] as $product) {
                        self::$contentList['details'] .= "<li><a href='?page=detail&id=" . $product->getId() . "'>" . $product->getName() . "</a></li>";
                    }
                }
                break;
        }
        self::$contentList['category'] .= '</ul>';
        self::$contentList['details'] .= '</ul>';
    }
}