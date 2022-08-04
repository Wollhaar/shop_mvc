<?php
declare(strict_types=1);

namespace Shop\Controller\Backend\Profile;

use Shop\Controller\BasicController;
use Shop\Core\View;
use Shop\Model\Dto\UserDataTransferObject;
use Shop\Model\Repository\UserRepository;
use Shop\Model\Mapper\UsersMapper;
use Shop\Model\EntityManager\UserEntityManager;

class UserProfileController implements BasicController
{
    private const TPL = 'UserProfileView.tpl';
    private View $renderer;
    private UserRepository $usrRepository;
    private UserEntityManager $usrEntManager;
    private UsersMapper $usrMapper;

    public function __construct(View $renderer, UserRepository $usrRepository, UserEntityManager $usrEntManager, UsersMapper $usrMapper)
    {
        $this->renderer = $renderer;
        $this->usrRepository = $usrRepository;
        $this->usrEntManager = $usrEntManager;
        $this->usrMapper = $usrMapper;
    }

    public function view(): void
    {
        $user = $this->action();
        $name = $user->username;

        if ((int)($_REQUEST['create'] ?? 0) === 1) {
            $create = true;
            $name = 'Creation';
        }
        $this->renderer->addTemplateParameter('User', 'title');
        $this->renderer->addTemplateParameter($name, 'subtitle');
        $this->renderer->addTemplateParameter($create ?? false, 'create');
        $this->renderer->addTemplateParameter($user, 'user');
    }

    public function display(): void
    {
        $this->renderer->display(self::TPL);
    }

    private function action(): UserDataTransferObject
    {
        $do = $_REQUEST['action'] ?? '';
        switch ($do) {
            case 'create':
                $user = $_POST['user'] ?? [];
                $password = $user['password'] ?? '';

                $this->usrEntManager->addUser($this->usrMapper->mapToDto($user), $password);
                return $this->usrRepository->getLastInsert();

            case 'save':
                $user = $_POST['user'];
                $password = $user['password'] ?? '';

                $user['id'] = (int)($user['id'] ?? 0);
                $user['updated'] = date('Y-m-d h:i:s') ?? '';
                $user['active'] = (bool)($user['active'] ?? 0);

                $user = $this->usrMapper->mapToDto($user);
                $this->usrEntManager->saveUser($user, $password);
                return $this->usrRepository->findUserById($user->id);

            default:
                $id = (int)($_REQUEST['id'] ?? 0);
                return $this->usrRepository->findUserById($id);
        }
    }
}