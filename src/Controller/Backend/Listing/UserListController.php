<?php
declare(strict_types=1);

namespace Shop\Controller\Backend\Listing;

use Shop\Core\View;
use Shop\Model\Repository\UserRepository;
use Shop\Model\EntityManager\UserEntityManager;

class UserListController implements \Shop\Controller\BasicController
{
    private const TPL = 'UserListView.tpl';

    public function __construct(private View $renderer, private UserRepository $usrRepository, private UserEntityManager $usrEntManager)
    {
    }

    public function view(): void
    {
        $action = $_GET['action'] ?? '';
        if ($action === 'delete') {
            $this->delete();
        }
        $users = $this->usrRepository->getAll();

        $this->renderer->addTemplateParameter('Users', 'title');
        $this->renderer->addTemplateParameter($users, 'users');
    }

    public function display(): void
    {
        $this->renderer->display(self::TPL);
    }

    private function delete(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $this->usrEntManager->deleteUserById($id);
    }
}