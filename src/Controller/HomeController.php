<?php declare(strict_types=1);

namespace Controller;

class HomeController
{
    private const page = 'home';

    private string $activePage = '';
    private int $id = 0;
    private string $output = '';

    public function __construct(array $request)
    {
        $this->activePage = $request['page'] ?? self::page;
        $this->id = (int) ($request['id'] ?? 0);
    }

    public function route():void
    {
        switch ($this->activePage) {
            case 'category':
                $control = new CategoryController();

                $category = $control->getById((int)$this->id);
                $exist = (bool)$control->getById((int)$this->id)->getId();


                if ($exist) {
                    $this->build($category->summarize());
                }
                else {
                    $this->build($control->collection);
                }
                break;

            case 'detail':
                $control = new ProductController();

                $product = $control->getById((int)$this->id);
                $exist = (bool)$control->getById((int)$this->id)->getId();


                if ($exist) {
                    $this->build($product->summarize());
                }
                else {
                    $this->build($control->collection);
                }
        }
    }

    public function build($data):void
    {
        $this->output = $this->activePage . '<br/><br/>';

        if (is_object(current($data))) {
            foreach ($data as $content) {
                $this->output .= '<a href="?page=' . $this->activePage . '&id=' . $content->getId() . '">' . $content->getName() . '</a><br/>';
            }
        }
        else {
            foreach ($data as $key => $value) {
                $this->output .= "$key: $value<br/>";
            }
        }
    }

    public function view():void
    {
        $test = $this->output;

        include ROOT_PATH . '/src/View/home.php';
    }
}