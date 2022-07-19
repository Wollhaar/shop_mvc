<?php declare(strict_types=1);

namespace Shop\Controller\Backend\Save;

use Shop\Core\View;
use Shop\Model\Repository\{CategoryRepository, ProductRepository, UserRepository};
use Shop\Model\Dto\ProductDataTransferObject;

class ProductSaveController implements \Shop\Controller\BasicController
{
    private const TPL = 'ProductProfileView.tpl';
    private View $renderer;
    private ProductRepository $prodRepository;

    public function __construct(View $renderer, CategoryRepository $catRepository, ProductRepository $prodRepository, UserRepository $usrRepository)
    {
        $this->renderer = $renderer;
        $this->prodRepository = $prodRepository;
    }

    public function view(): void
    {
        $product = $this->build();

        $this->renderer->addTemplateParameter('Product', 'title');
        $this->renderer->addTemplateParameter($product, 'product');
    }

    public function display(): void
    {
        $this->renderer->display(self::TPL);
    }

    private function build(): ProductDataTransferObject
    {
        $product = $_REQUEST['product'];
        return $this->prodRepository->saveProduct($product);
    }
}