<?php
declare(strict_types=1);

namespace Shop\Controller\Backend\Profile;

use Shop\Core\View;
use Shop\Model\Dto\ProductDataTransferObject;
use Shop\Model\Repository\{CategoryRepository, ProductRepository, UserRepository};
use Shop\Model\Mapper\CategoriesMapper;
use Shop\Model\Mapper\ProductsMapper;

class ProductProfileController implements \Shop\Controller\BasicController
{
    private const TPL = 'ProductProfileView.tpl';
    private View $renderer;
    private ProductRepository $prodRepository;
    private ProductsMapper $prodMapper;
    private CategoryRepository $catRepository;

    public function __construct(View $renderer, CategoryRepository $catRepository, ProductRepository $prodRepository, ProductsMapper $prodMapper)
    {
        $this->renderer = $renderer;
        $this->prodRepository = $prodRepository;
        $this->catRepository = $catRepository;
        $this->prodMapper = $prodMapper;
    }

    public function view(): void
    {
        $product = $this->action();
        $categories = $this->catRepository->getAll();
        $name = $product->name;

        if ((int)($_REQUEST['create'] ?? 0) === 1) {
            $create = true;
            $name = 'Creation';
        }
        $this->renderer->addTemplateParameter('Product', 'title');
        $this->renderer->addTemplateParameter($name, 'subtitle');
        $this->renderer->addTemplateParameter($create ?? false, 'create');
        $this->renderer->addTemplateParameter($product, 'product');
        $this->renderer->addTemplateParameter($categories, 'categories');
    }

    public function display(): void
    {
        $this->renderer->display(self::TPL);
    }

    private function action(): ProductDataTransferObject
    {
        $do = $_REQUEST['action'] ?? '';
        switch ($do) {
            case 'create':
                $product = $_POST['product'] ?? [];
                $product['price'] = (float)($product['price'] ?? 0);
                $product['amount'] = (int)($product['amount'] ?? 0);

                $product = $this->prodMapper->mapToDto($product);
                return $this->prodRepository->addProduct($product);

            case 'save':
                $product = $_POST['product'];
                $product['id'] = (int)($product['id'] ?? 0);
                $product['price'] = (float)($product['price'] ?? 0);
                $product['amount'] = (int)($product['amount'] ?? 0);
                $product['active'] = (bool)($product['active'] ?? 0);

                $product = $this->prodMapper->mapToDto($product);
                return $this->prodRepository->saveProduct($product);

            default:
                $id = (int)($_REQUEST['id'] ?? 0);
                return $this->prodRepository->findProductById($id);
        }
    }
}