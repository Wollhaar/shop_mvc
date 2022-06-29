<?php declare(strict_types=1);

namespace Shop\Controller;

use Shop\Core\View;
use Shop\Model\Repository\{CategoryRepository, ProductRepository};
use Shop\Model\Product;

class DetailController implements BasicController
{

    private const TPL = 'DetailView.tpl';

    private ProductRepository $prodRepository;

    private View $renderer;

    private Product $activeProduct;

    private int $productAmount = 0;


    public function __construct(View $renderer, CategoryRepository $catRepository, ProductRepository $prodRepository)
    {
        $request = $_REQUEST;
        $activeId = (int) ($request['id'] ?? 0);
        $this->activeProduct = new Product($activeId);
        $this->renderer = $renderer;
        $this->prodRepository = $prodRepository;
    }

    public function view(): void
    {
        $this->build();

        $this->renderer->addTemplateParameter($this->activeProduct->getId(), 'id');
        $this->renderer->addTemplateParameter($this->activeProduct->getName(), 'name');
        $this->renderer->addTemplateParameter($this->activeProduct->getSize(), 'size');
        $this->renderer->addTemplateParameter($this->activeProduct->getCategory(), 'category');
        $this->renderer->addTemplateParameter($this->activeProduct->getPrice(), 'price');
        $this->renderer->addTemplateParameter($this->productAmount, 'amount');
    }

    public function display(): void
    {
        $this->renderer->display(self::TPL);
    }

    private function build(): void
    {
        if ($this->activeProduct->getId() && $this->activeProduct->getId() <= count($this->prodRepository->getAll())) {
            $activeProduct = $this->prodRepository->findProductById($this->activeProduct->getId());
            $this->activeProduct->setName($activeProduct['name']);
            $this->activeProduct->setSize($activeProduct['size']);
            $this->activeProduct->setCategory($activeProduct['categoryName']);
            $this->activeProduct->setPrice($activeProduct['price']);
            $this->productAmount = $activeProduct['amount'];
        }
    }
}