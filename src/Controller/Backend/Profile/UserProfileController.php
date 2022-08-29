<?php
declare(strict_types=1);

namespace Shop\Controller\Backend\Profile;

use Shop\Controller\BasicController;
use Shop\Core\PasswordGenerator;
use Shop\Core\View;
use Shop\Model\Dto\UserDataTransferObject;
use Shop\Model\Repository\UserRepository;
use Shop\Model\Mapper\UsersMapper;
use Shop\Model\EntityManager\UserEntityManager;

class UserProfileController implements BasicController
{
    private const TPL = 'UserProfileView.tpl';

    public function __construct(
        private View $renderer,
        private UserRepository $usrRepository,
        private UserEntityManager $usrEntManager,
        private UsersMapper $usrMapper,
        private PasswordGenerator $generator
    )
    {}

    public function view(): void
    {
        $action = $_GET['action'] ?? 'index';
        $user = $this->$action();

        if (is_object($user)) {
            $name = $user->username;
        }
        if ((int)($_GET['create'] ?? 0) === 1) {
            $create = true;
            $name = 'Creation';
        }
        $this->renderer->addTemplateParameter('User', 'title');
        $this->renderer->addTemplateParameter($name ?? null, 'subtitle');
        $this->renderer->addTemplateParameter($create ?? false, 'create');
        $this->renderer->addTemplateParameter($user ?? null, 'user');
    }

    public function display(): void
    {
        $this->renderer->display(self::TPL);
    }

    public function index(): UserDataTransferObject|null
    {
        $id = (int)($_GET['id'] ?? 0);
        return $this->usrRepository->findUserById($id);
    }

    public function create(): UserDataTransferObject
    {
        $user = $_POST['user'] ?? [];
        $user['id'] = 0;

        $user['passwordHash'] = '';
        if (isset($user['password']) && $user['password'] !== '') {
            $user['passwordHash'] = $this->generator->hash($user['password']);
        }
        $user['created'] = date('Y-m-d h:i:s') ?? '';
        $user['updated'] = '';
        $user['active'] = true;

        $userId = $this->usrEntManager->addUser($this->usrMapper->mapToDto($user));
        return $this->usrRepository->findUserById($userId);
    }

    public function save(): UserDataTransferObject
    {
        $user = $_POST['user'];
        $user['id'] = (int)($user['id'] ?? 0);

        $user['passwordHash'] = $user['password'] ?? '';
        if (isset($user['password']) && $user['password'] !== '') {
            $user['passwordHash'] = $this->generator->hash($user['passwordHash']);
        }

        $user['created'] = '';
        $user['updated'] = date('Y-m-d h:i:s') ?? '';
        $user['active'] = (bool)($user['active']);

        $user = $this->usrMapper->mapToDto($user);
        $this->usrEntManager->saveUser($user);
        return $this->usrRepository->findUserById($user->id);
    }
}