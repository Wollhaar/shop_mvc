<?php
declare(strict_types=1);

namespace Shop\Controller\Backend\Profile;

use Shop\Controller\BasicController;
use Shop\Core\View;
use Shop\Model\Dto\UserDataTransferObject;
use Shop\Model\Repository\{CategoryRepository, ProductRepository, UserRepository};
use Shop\Model\Mapper\{CategoriesMapper, ProductsMapper, UsersMapper};

class UserProfileController implements BasicController
{
    private const TPL = 'UserProfileView.tpl';
    private View $renderer;
    private UserRepository $usrRepository;
    private UsersMapper $usrMapper;

    public function __construct(View $renderer, CategoryRepository $catRepository, ProductRepository $prodRepository, UserRepository $usrRepository, CategoriesMapper $catMapper, ProductsMapper $prodMapper, UsersMapper $usrMapper)
    {
        $this->renderer = $renderer;
        $this->usrRepository = $usrRepository;
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
                $user = $_REQUEST['user'] ?? [];
                $password = $user['password'] ?? '';

                return $this->usrRepository->addUser($this->usrMapper->mapToDto($user), $password);

            case 'save':
                $user = $_POST['user'];
                $password = $_POST['password'] ?? '';

                $user['id'] = (int)$user['id'];
                $user['updated'] = date('Y-m-d');
                $user['active'] = (bool)$user['active'];

                $user = $this->usrMapper->mapToDto($user);
                return $this->usrRepository->saveUser($user, $password);

            default:
                $id = (int)($_REQUEST['id'] ?? 0);
                return $this->usrRepository->findUserById($id);
        }
    }
}