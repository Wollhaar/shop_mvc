<?php
declare(strict_types=1);

namespace Shop\Controller;

use Shop\Core\View;
use Shop\Model\Dto\CategoryDataTransferObject;
use Shop\Model\Dto\ProductDataTransferObject;
use Shop\Model\Dto\UserDataTransferObject;
use Shop\Model\Repository\CategoryRepository;
use Shop\Model\Repository\ProductRepository;
use Shop\Model\Repository\UserRepository;

class CreateController implements BasicController
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
        $category = $this->buildCategory();
        $categories = $this->catRepository->getAll();

        $active = $request['page'] ?? $request['save'] ?? $request['create'];
        $this->renderer->addTemplateParameter(ucfirst($active), 'title');
        $this->renderer->addTemplateParameter($active, 'active');
        $this->renderer->addTemplateParameter($user, 'user');
        $this->renderer->addTemplateParameter($product, 'product');
        $this->renderer->addTemplateParameter($category, 'category');
        $this->renderer->addTemplateParameter($categories, 'categories');
    }

    public function display(): void
    {
        $this->renderer->display(self::TPL);
    }

    private function buildProduct(): ProductDataTransferObject
    {
        $request = $_REQUEST;
        $create = $request['page'] ?? '';
        $product = $this->prodRepository->findProductById(0);
        if ($create === 'product' && isset($request['product'])) {
            $product = $this->prodRepository->addProduct($request['product']);
        }
        return $product;
    }

    private function buildCategory(): CategoryDataTransferObject
    {
        $request = $_REQUEST;
        $create = $request['page'] ?? '';
        $category = $this->catRepository->findCategoryById(0);
        if ($create === 'category' && isset($request['category'])) {
            $category = $this->catRepository->addCategory($request['category']);
        }
        return $category;
    }

    private function buildUser(): UserDataTransferObject
    {
        $request = $_REQUEST;
        $create = $request['page'] ?? '';
        $user = $this->usrRepository->findUserById(0);
        if ($create === 'user' && isset($request['user'])) {
            $user = $this->usrRepository->addUser($request['user']);
        }
        return $user;
    }
}