<?php
declare(strict_types=1);

namespace Shop\Controller\Backend\Profile;

use Shop\Core\View;
use Shop\Model\Dto\ProductDataTransferObject;
use Shop\Model\Repository\CategoryRepository;
use Shop\Model\Repository\ProductRepository;
use Shop\Model\Repository\UserRepository;

class ProductProfileController implements \Shop\Controller\BasicController
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

        if ((int)($request['create'] ?? 0) === 1) {
            $create = true;
        }
        $this->renderer->addTemplateParameter('Users', 'title');
        $this->renderer->addTemplateParameter($product->name, 'subtitle');
        $this->renderer->addTemplateParameter($create ?? false, 'create');
        $this->renderer->addTemplateParameter($product, 'product');
    }

    public function display(): void
    {
        $this->renderer->display(self::TPL);
    }

    private function build(): ProductDataTransferObject
    {
        $id = (int)($_REQUEST['id'] ?? 0);
        return $this->prodRepository->findProductById($id);
    }
}