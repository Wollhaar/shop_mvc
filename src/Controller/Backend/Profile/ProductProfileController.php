<?php
declare(strict_types=1);

namespace Shop\Controller\Backend\Profile;

use Shop\Core\View;
use Shop\Model\Dto\ProductDataTransferObject;
use Shop\Model\EntityManager\ProductEntityManager;
use Shop\Model\Mapper\ProductsMapper;
use Shop\Model\Repository\{CategoryRepository, ProductRepository};

class ProductProfileController implements \Shop\Controller\BasicController
{
    private const TPL = 'ProductProfileView.tpl';

    public function __construct(
        private View $renderer,
        private CategoryRepository $catRepository,
        private ProductRepository $prodRepository,
        private ProductEntityManager $prodEntManager,
        private ProductsMapper $prodMapper)
    {
    }

    public function view(): void
    {
        $action = $_GET['action'] ?? 'index';
        $product = $this->$action();

        $categories = $this->catRepository->getAll();

        if (is_object($product)) {
            $name = $product->name;
        }
        if ((int)($_REQUEST['create'] ?? 0) === 1) {
            $create = true;
            $name = 'Creation';
        }
        $this->renderer->addTemplateParameter('Product', 'title');
        $this->renderer->addTemplateParameter($name ?? null, 'subtitle');
        $this->renderer->addTemplateParameter($create ?? false, 'create');
        $this->renderer->addTemplateParameter($product, 'product');
        $this->renderer->addTemplateParameter($categories, 'categories');
    }

    public function display(): void
    {
        $this->renderer->display(self::TPL);
    }

    private function index(): ProductDataTransferObject|null
    {
        $id = (int)($_REQUEST['id'] ?? 0);
        return $this->prodRepository->findProductById($id);
    }

    private function create(): ProductDataTransferObject
    {
        $product = $_POST['product'] ?? [];
        $product['price'] = (float)($product['price'] ?? 0);
        $product['amount'] = (int)($product['amount'] ?? 0);

        $product = $this->prodMapper->mapToDto($product);
        $productId = $this->prodEntManager->addProduct($product);
        return $this->prodRepository->findProductById($productId);
    }

    private function save(): ProductDataTransferObject
    {
        $product = $_POST['product'];
        $product['id'] = (int)($product['id'] ?? 0);
        $product['price'] = (float)($product['price'] ?? 0);
        $product['amount'] = (int)($product['amount'] ?? 0);
        $product['active'] = (bool)($product['active'] ?? 0);

        $product = $this->prodMapper->mapToDto($product);
        $this->prodEntManager->saveProduct($product);
        return $this->prodRepository->findProductById($product->id);
    }
}