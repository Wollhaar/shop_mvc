<?php
declare(strict_types=1);

namespace Shop\Controller;

use Shop\Core\View;
use Shop\Model\Dto\ProductDataTransferObject;
use Shop\Model\Dto\UserDataTransferObject;
use Shop\Model\Repository\CategoryRepository;
use Shop\Model\Repository\ProductRepository;
use Shop\Model\Repository\UserRepository;

class SaveController implements BasicController
{
    private const TPL = 'ProfileView.tpl';
    private View $renderer;
    private CategoryRepository $catRepository;
    private ProductRepository $prodRepository;
    private UserRepository $usrRepository;

    public function __construct(View $renderer, CategoryRepository $catRepository, ProductRepository $prodRepository, UserRepository $usrRepository)
    {
        $this->renderer = $renderer;
        $this->catRepository = $catRepository;
        $this->prodRepository = $prodRepository;
        $this->usrRepository = $usrRepository;
    }


    public function view(): void
    {
        $request =  $_REQUEST;
        $user = $this->buildUser();
        $product = $this->buildProduct();
        $categories = $this->catRepository->getAll();

        $active =  $request['save'] ?? '';
        $this->renderer->addTemplateParameter(ucfirst($active), 'title');
        $this->renderer->addTemplateParameter($active, 'active');
        $this->renderer->addTemplateParameter($user, 'user');
        $this->renderer->addTemplateParameter($product, 'product');
        $this->renderer->addTemplateParameter($categories, 'categories');
    }

    public function display(): void
    {
        $this->renderer->display(self::TPL);
    }

    private function buildProduct(): ProductDataTransferObject
    {
        $request = $_REQUEST;
        $save = $request['page'] ?? '';
        $product = $this->prodRepository->findProductById(0);
        if ($save === 'product' && isset($request['product'])) {
            $product = $this->prodRepository->saveProduct($request['product']);
        }
        return $product;
    }

    private function buildUser(): UserDataTransferObject
    {
        $request = $_REQUEST;
        $save = $request['page'] ?? '';
        $user = $this->usrRepository->findUserById(0);
        if ($save === 'user' && isset($request['user'])) {
            $user = $this->usrRepository->saveUser($request['user']);
        }
        return $user;
    }
}