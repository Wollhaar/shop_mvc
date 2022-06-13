<?php declare(strict_types=1);

namespace Controller;

use Model\Category;

class HomeController implements BasicController
{
    private const page = 'home';

    private string $output = '<span style="color: chartreuse">Shop</span><br/>';

    public function __construct()
    {
        $this->build();
    }

    public function __destruct()
    {
        inputHTML('###' . self::page . '###', ROOT_PATH . '/src/View/home.php', $this->output);
    }

    public function view():void
    {
        inputHTML($this->output, ROOT_PATH . '/src/View/home.php', '###' . self::page . '###');
        include ROOT_PATH . '/src/View/home.php';
    }

    private function getCategories():array
    {
        global $categoryCollection;
        $categories = [];

        foreach ($categoryCollection as $id => $category) {
            $categories[$id] = new Category((int) $id, $category);
        }

        return $categories;
    }

    private function build():void
    {
        $this->output .= '<p>';
        foreach ($this->getCategories() as $content) {
            $this->output .= '<a href="?page=category&id=' . $content->getId() . '">' . $content->getName() . '</a><br/>';
        }
        $this->output .= '</p>';
    }
}