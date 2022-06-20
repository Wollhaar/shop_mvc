<?php declare(strict_types=1);

namespace Shop\Controller;

use Shop\Core\View;
use Shop\Model\Product;

class ProductController implements BasicController
{
    private const TPL = 'DetailView.tpl';

    private Product $activeProduct;


    public function __construct()
    {
        $request = $_REQUEST;
        $this->activeProduct = new Product((int)($request['id'] ?? 0));
    }

    public function view():void
    {
        $renderer = new View();

        if ($this->activeProduct->getId()) {
            $renderer->addTemplateParameterInteger($this->activeProduct->getId(), 'id');
            $renderer->addTemplateParameter($this->activeProduct->getName(), 'name');
            $renderer->addTemplateParameter($this->activeProduct->getCategory(), 'category');
            $renderer->addTemplateParameterFloat($this->activeProduct->getPrice(), 'price');
            $renderer->addTemplateParameterInteger((new Product())->getAll()[$this->activeProduct->getId()]['amount'], 'amount');
        }

        $renderer->display(self::TPL);
    }
}