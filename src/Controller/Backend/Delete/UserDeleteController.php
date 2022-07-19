<?php
declare(strict_types=1);

namespace Shop\Controller\Backend\Delete;

use Shop\Core\View;
use Shop\Model\Repository\{CategoryRepository, ProductRepository, UserRepository};

class UserDeleteController implements \Shop\Controller\BasicController
{
    private const TPL = 'UserListView.tpl';
    private View $renderer;
    private UserRepository $usrRepository;

    public function __construct(View $renderer, CategoryRepository $catRepository, ProductRepository $prodRepository, UserRepository $usrRepository)
    {
        $this->renderer = $renderer;
        $this->usrRepository = $usrRepository;
    }

    public function view(): void
    {
        $users = $this->build();

        $this->renderer->addTemplateParameter('Users', 'title');
        $this->renderer->addTemplateParameter($users, 'users');
    }

    public function display(): void
    {
        $this->renderer->display(self::TPL);
    }

    private function build(): array
    {
        $id = (int)($_REQUEST['id'] ?? 0);
        $this->usrRepository->deleteUserById($id);
        return $this->usrRepository->getAll();
    }
}