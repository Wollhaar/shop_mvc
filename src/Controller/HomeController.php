<?php declare(strict_types=1);

namespace Shop\Controller;

use Shop\Controller\Data\DataHandler;
use Shop\Core\View;
use Shop\Model\Category;

class HomeController implements BasicController
{
    private const TPL = 'HomeView.tpl';

    private DataHandler $dataHandler;

    private string $output = '<span style="color: chartreuse">Shop</span><br/>';

    public function __construct()
    {
        $this->dataHandler = DataHandler::getInstance();
        $this->build();
    }

    public function view():void
    {
        $renderer = new View();
        $renderer->addTemplateParameter($this->output, 'output');
        $renderer->display(self::TPL);
    }

    private function build():void
    {
        $this->output .= '<p>';
        foreach ($this->getCategories() as $content) {
            $this->output .= '<a href="?page=category&id=' . $content->getId() . '">' . $content->getName() . '</a><br/>';
        }
        $this->output .= '</p>';
    }

    private function getCategories():array
    {
        $categories = [];

        foreach ($this->dataHandler->get('categories') as $id => $category) {
            $categories[$id] = new Category($id, $category['name']);
        }

        return $categories;
    }
}