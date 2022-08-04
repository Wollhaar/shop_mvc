<?php
declare(strict_types=1);

namespace Shop\Controller\Backend\Listing;

use Shop\Core\View;
use Shop\Model\Repository\UserRepository;
use Shop\Model\EntityManager\UserEntityManager;

class UserListController implements \Shop\Controller\BasicController
{
    private const TPL = 'UserListView.tpl';
    private View $renderer;
    private UserRepository $usrRepository;
    private UserEntityManager $usrEntManager;

    public function __construct(View $renderer, UserRepository $usrRepository, UserEntityManager $usrEntManager)
    {
        $this->renderer = $renderer;
        $this->usrRepository = $usrRepository;
        $this->usrEntManager = $usrEntManager;
    }

    public function view(): void
    {
        $this->action();
        $users = $this->usrRepository->getAll();

        $this->renderer->addTemplateParameter('Users', 'title');
        $this->renderer->addTemplateParameter($users, 'users');
    }

    public function display(): void
    {
        $this->renderer->display(self::TPL);
    }

    private function action(): void
    {
        $do = $_REQUEST['action'] ?? '';
        if ($do === 'delete') {
            $id = (int)($_REQUEST['id'] ?? 0);
            $this->usrEntManager->deleteUserById($id);
        }
    }
}