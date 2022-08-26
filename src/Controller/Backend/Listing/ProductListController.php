<?php declare(strict_types=1);

namespace Shop\Controller\Backend\Listing;

use Shop\Core\View;
use Shop\Model\EntityManager\ProductEntityManager;
use Shop\Model\Repository\{ProductRepository};

class ProductListController implements \Shop\Controller\BasicController
{
    private const TPL = 'ProductListView.tpl';

    public function __construct(private View $renderer, private ProductRepository $prodRepository, private ProductEntityManager $prodEntManager)
    {
    }

    public function view(): void
    {
        $action = $_GET['action'] ?? '';
        if ($action === 'delete') {
            $this->delete();
        }
        $products = $this->prodRepository->getAll();

        $this->renderer->addTemplateParameter('Product', 'title');
        $this->renderer->addTemplateParameter($products, 'products');
    }

    public function display(): void
    {
        $this->renderer->display(self::TPL);
    }

    private function delete(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $this->prodEntManager->deleteProductById($id);
    }
}