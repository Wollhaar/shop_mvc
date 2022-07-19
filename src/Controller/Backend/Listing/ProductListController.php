<?php declare(strict_types=1);

namespace Shop\Controller\Backend\Listing;

use Shop\Core\View;
use Shop\Model\Repository\{CategoryRepository, ProductRepository, UserRepository};

class ProductListController implements \Shop\Controller\BasicController
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
        $products = $this->prodRepository->getAll();

        $this->renderer->addTemplateParameter('Product', 'title');
        $this->renderer->addTemplateParameter($products, 'products');
    }

    public function display(): void
    {
        $this->renderer->display(self::TPL);
    }
}