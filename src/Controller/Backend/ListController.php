<?php
declare(strict_types=1);

namespace Shop\Controller\Backend;

use Shop\Controller\BasicController;
use Shop\Core\View;
use Shop\Model\Repository\CategoryRepository;
use Shop\Model\Repository\ProductRepository;
use Shop\Model\Repository\UserRepository;

class ListController implements BasicController
{
    private const TPL = 'ListView.tpl';
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
        $users = $this->buildUsers();
        $categories = $this->buildCategories();
        $products = $this->buildProducts();

        $page = $_REQUEST['page'] ?? 'Nicht gefunden';
        $activeCategories = $page === 'categories';
        $activeProducts = $page === 'products';
        $activeUsers = $page === 'users';

        $this->renderer->addTemplateParameter(ucfirst($page), 'title');
        $this->renderer->addTemplateParameter($activeCategories, 'activeCategories');
        $this->renderer->addTemplateParameter($activeProducts, 'activeProducts');
        $this->renderer->addTemplateParameter($activeUsers, 'activeUsers');
        $this->renderer->addTemplateParameter($categories, 'categories');
        $this->renderer->addTemplateParameter($products, 'products');
        $this->renderer->addTemplateParameter($users, 'users');
    }

    public function display(): void
    {
        $this->renderer->display(self::TPL);
    }

    private function buildCategories(): array
    {
        $built = [];
        if ($_REQUEST['page'] === 'categories') {
            if (isset($request['delete'])) {
                $this->catRepository->deleteCategoryById((int) $request['delete']);
            }
            $built = $this->catRepository->getAll();
        }
        return $built;
    }

    private function buildProducts(): array
    {
        $request = $_REQUEST;
        $built = [];
        if ($request['page'] === 'products') {
            if (isset($request['delete'])) {
                $this->prodRepository->deleteProductById((int) $request['delete']);
            }
            $built = $this->prodRepository->getAll();
        }
        return $built;
    }

    private function buildUsers(): array
    {
        $built = [];
        if ($_REQUEST['page'] === 'users') {
            if (isset($request['delete'])) {
                $this->usrRepository->deleteUserById((int) $request['delete']);
            }
            $built = $this->usrRepository->getAll();
        }
        return $built;
    }
}