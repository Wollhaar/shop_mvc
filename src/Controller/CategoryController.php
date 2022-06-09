<?php declare(strict_types=1);

namespace Controller;

use Model\Shop\Category;

class CategoryController
{
    private const page = 'category';

    private const categories = [
        1 => 'T-Shirt',
        2 => 'Pullover',
        3 => 'Hosen',
        4 => 'Sportswear',
    ];

    private int $activeId = 0;
    private string $output = self::page . '<br/><br/>';

    public array $collection = [];


    public function __construct()
    {
        $request = $_REQUEST;
        $this->activeId = (int) ($request['id'] ?? 0);

        foreach (self::categories as $id => $name) {
            $this->collection[$id] = new Category($id, $name);
        }
    }

    public function build():void
    {
        $category = $this->collection[$this->activeId] ?? new Category(0, 'none');
        $exist = (bool)$category->getId();

        if ($exist) {
            foreach ($category->summarize() as $key => $value) {
                $this->output .= "$key: $value<br/>";
            }
        }
        else {
            foreach ($this->collection as $content) {
                $this->output .= '<a href="?page=' . self::page . '&id=' . $content->getId() . '">' . $content->getName() . '</a><br/>';
            }
        }
    }

    public function view():void
    {
        $this->build();
        $test = $this->output;

        include ROOT_PATH . '/src/View/home.php';
    }
}