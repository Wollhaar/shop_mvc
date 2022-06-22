<?php declare(strict_types=1);

namespace Shop\Controller;

use Shop\Core\View;
use Shop\Model\Category;

class HomeController implements BasicController
{
    private const TPL = 'HomeView.tpl';

    private array $output = [];

    private View $renderer;


    public function view():void
    {
        $this->build();
        $this->renderer = new View();

        $this->renderer->addTemplateParameter('Shop', 'title');
        $this->renderer->addTemplateParameter($this->output, 'output');
    }

    public function display(): void
    {
        $this->renderer->display(self::TPL);
    }


    public function check(): array
    {
        return $this->renderer->getParams();
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