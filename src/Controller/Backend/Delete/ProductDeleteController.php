<?php
declare(strict_types=1);

namespace Shop\Controller\Backend\Delete;

use Shop\Controller\BasicController;
use Shop\Core\View;
use Shop\Model\Repository\{CategoryRepository, ProductRepository, UserRepository};

class ProductDeleteController implements BasicController
{
    private const TPL = 'ProductListView.tpl';
    private View $renderer;
    private ProductRepository $prodRepository;

    public function __construct(View $renderer, CategoryRepository $catRepository, ProductRepository $prodRepository, UserRepository $usrRepository)
    {
        $this->renderer = $renderer;
        $this->prodRepository = $prodRepository;
    }
    public function view(): void
    {
        $products = $this->build();

        $this->renderer->addTemplateParameter('Products', 'title');
        $this->renderer->addTemplateParameter($products, 'products');
    }

    public function display(): void
    {
        $this->renderer->display(self::TPL);
    }

    private function build(): array
    {
        $id = (int)($_REQUEST['id'] ?? 0);
        $this->prodRepository->deleteProductById($id);

        return $this->prodRepository->getAll();
    }
}