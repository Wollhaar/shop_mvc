<?php
declare(strict_types=1);

namespace Shop\Controller\Backend\Create;

use Shop\Core\View;
use Shop\Model\Dto\ProductDataTransferObject;
use Shop\Model\Repository\CategoryRepository;
use Shop\Model\Repository\ProductRepository;
use Shop\Model\Repository\UserRepository;

class ProductCreateController implements \Shop\Controller\BasicController
{
    private const TPL = 'ProductProfileView.tpl';
    private View $renderer;
    private ProductRepository $prodRepository;
    private CategoryRepository $catRepository;

    public function __construct(View $renderer, CategoryRepository $catRepository, ProductRepository $prodRepository, UserRepository $usrRepository)
    {
        $this->renderer = $renderer;
        $this->prodRepository = $prodRepository;
        $this->catRepository = $catRepository;
    }

    public function view(): void
    {
        $product = $this->build();
        $categories = $this->catRepository->getAll();

        $this->renderer->addTemplateParameter('Product', 'title');
        $this->renderer->addTemplateParameter(false, 'create');
        $this->renderer->addTemplateParameter($product->name, 'subtitle');
        $this->renderer->addTemplateParameter($product, 'product');
        $this->renderer->addTemplateParameter($categories, 'categories');
    }

    public function display(): void
    {
        $this->renderer->display(self::TPL);
    }

    private function build(): ProductDataTransferObject
    {
        $product = $_REQUEST['product'] ?? [];
        return $this->prodRepository->addProduct($product);
    }
}