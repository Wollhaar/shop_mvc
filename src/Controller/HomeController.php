<?php declare(strict_types=1);

namespace Shop\Controller;

use Shop\Core\View;
use Shop\Model\Category;

class HomeController implements BasicController
{
    private const TPL = 'HomeView.tpl';

    private array $output = [];


    public function view():void
    {
        $this->build();
        $renderer = new View();

        $renderer->addTemplateParameter('Shop', 'title');
        $renderer->addTemplateParameterArray($this->output, 'output');
        $renderer->display(self::TPL);
    }

    private function build():void
    {
        foreach ($this->getCategories() as $category) {
            $this->output[$category['id']] = $category['name'];
        }
    }

    private function getCategories():array
    {
        return (new Category())->getAll();
    }
}