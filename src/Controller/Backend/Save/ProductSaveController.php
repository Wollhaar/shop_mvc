<?php declare(strict_types=1);

namespace Shop\Controller\Backend\Save;

use Shop\Core\View;
use Shop\Model\Repository\{CategoryRepository, ProductRepository, UserRepository};
use Shop\Model\Dto\ProductDataTransferObject;
use Shop\Model\Mapper\CategoriesMapper;
use Shop\Model\Mapper\ProductsMapper;

class ProductSaveController implements \Shop\Controller\BasicController
{
    private const TPL = 'ProductProfileView.tpl';
    private View $renderer;
    private ProductRepository $prodRepository;
    private CategoryRepository $catRepository;
    private ProductsMapper $mapper;

    public function __construct(View $renderer, CategoryRepository $catRepository, ProductRepository $prodRepository, UserRepository $usrRepository, CategoriesMapper $catMapper, ProductsMapper $prodMapper)
    {
        $this->renderer = $renderer;
        $this->prodRepository = $prodRepository;
        $this->catRepository = $catRepository;
        $this->mapper = $prodMapper;
    }

    public function view(): void
    {
        $product = $this->build();
        $categories = $this->catRepository->getAll();

        $this->renderer->addTemplateParameter('Product', 'title');
        $this->renderer->addTemplateParameter($product->name, 'subtitle');
        $this->renderer->addTemplateParameter(false, 'create');
        $this->renderer->addTemplateParameter($product, 'product');
        $this->renderer->addTemplateParameter($categories, 'categories');
    }

    public function display(): void
    {
        $this->renderer->display(self::TPL);
    }

    private function build(): ProductDataTransferObject
    {
        $product = $_POST['product'];
        $product['id'] = (int)$product['id'];
        $product['price'] = (float)$product['price'];
        $product['amount'] = (int)$product['amount'];
        $product['active'] = (bool)$product['active'];

        $product = $this->mapper->mapToDto($product);
        return $this->prodRepository->saveProduct($product);
    }
}