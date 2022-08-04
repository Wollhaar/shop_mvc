<?php declare(strict_types=1);

namespace Shop\Controller\Backend\Listing;

use Shop\Core\View;
use Shop\Model\EntityManager\ProductEntityManager;
use Shop\Model\Repository\{ProductRepository};

class ProductListController implements \Shop\Controller\BasicController
{
    private const TPL = 'ProductListView.tpl';
    private View $renderer;
    private ProductRepository $prodRepository;
    private ProductEntityManager $prodEntManager;

    public function __construct(View $renderer, ProductRepository $prodRepository, ProductEntityManager $prodEntManager)
    {
        $this->renderer = $renderer;
        $this->prodRepository = $prodRepository;
        $this->prodEntManager = $prodEntManager;
    }

    public function view(): void
    {
        $this->action();
        $products = $this->prodRepository->getAll();

        $this->renderer->addTemplateParameter('Product', 'title');
        $this->renderer->addTemplateParameter($products, 'products');
    }

    public function display(): void
    {
        $this->renderer->display(self::TPL);
    }

    private function action(): void
    {
        $do = $_REQUEST['action'] ?? '';
        if ($do === 'delete') {
            $id = (int)($_REQUEST['id'] ?? 0);
            $this->prodEntManager->deleteProductById($id);
        }
    }
}