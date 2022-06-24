<?php declare(strict_types=1);

namespace Shop\Controller;

use Shop\Core\View;
use Shop\Model\Product;

class DetailController implements BasicController
{
    private const TPL = 'DetailView.tpl';

    private Product $activeProduct;

    private View $renderer;


    public function __construct(View $renderer)
    {
        $request = $_REQUEST;
        $this->activeProduct = new Product((int)($request['id'] ?? 0));
        $this->renderer = $renderer;
    }

    public function view():void
    {
        $products = (new Product())->getAll();

        $id = $this->activeProduct->getId();
        $amount = 0;
        if ($id && $id < count($products)) {
            $amount = $products[$id]['amount'];
        }

        $this->renderer->addTemplateParameter($id, 'id');
        $this->renderer->addTemplateParameter($this->activeProduct->getName(), 'name');
        $this->renderer->addTemplateParameter($this->activeProduct->getSize(), 'size');
        $this->renderer->addTemplateParameter($this->activeProduct->getCategory(), 'category');
        $this->renderer->addTemplateParameter($this->activeProduct->getPrice(), 'price');
        $this->renderer->addTemplateParameter($amount, 'amount');
    }

    public function display(): void
    {
        $this->renderer->display(self::TPL);
    }
}