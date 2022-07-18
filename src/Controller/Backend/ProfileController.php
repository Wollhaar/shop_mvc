<?php
declare(strict_types=1);

namespace Shop\Controller\Backend;

use Shop\Controller\BasicController;
use Shop\Core\View;
use Shop\Model\Dto\{ProductDataTransferObject, UserDataTransferObject};
use Shop\Model\Repository\{CategoryRepository, ProductRepository, UserRepository};

class ProfileController implements BasicController
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

        if ((int)($request['create'] ?? 0) === 1) {
            $create = true;
        }
        $active = $request['page'] ?? '';
        $this->renderer->addTemplateParameter(ucfirst($active), 'title');
        $this->renderer->addTemplateParameter((bool)($create ?? 0), 'create');
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
        $page = $request['page'] ?? '';
        $product = $this->prodRepository->findProductById(0);
        if ($page === 'product' && isset($request['id'])) {
            $product = $this->prodRepository->findProductById((int) $request['id']);
        }
        return $product;
    }

    private function buildUser(): UserDataTransferObject
    {
        $request = $_REQUEST;
        $page = $request['page'] ?? '';
        $user = $this->usrRepository->findUserById(0);
        if ($page === 'user' && isset($request['id'])) {
            $user = $this->usrRepository->findUserById((int) $request['id']);
        }
        return $user;
    }
}