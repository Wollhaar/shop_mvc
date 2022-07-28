<?php
declare(strict_types=1);

namespace Shop\Controller\Backend\Save;

use Shop\Controller\BasicController;
use Shop\Core\View;
use Shop\Model\Dto\UserDataTransferObject;
use Shop\Model\Repository\{CategoryRepository, ProductRepository, UserRepository};
use Shop\Model\Mapper\{CategoriesMapper, ProductsMapper, UsersMapper};

class UserSaveController implements BasicController
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
        $user = $this->build();

        $this->renderer->addTemplateParameter('User', 'title');
        $this->renderer->addTemplateParameter($user, 'user');
    }

    public function display(): void
    {
        $this->renderer->display(self::TPL);
    }

    private function build(): UserDataTransferObject
    {
        $user = $_POST['user'];
        $password = $_POST['password'];

        $user['updated'] = date('Y-m-d');
        $user['active'] = (bool)$user['active'];

        $user = $this->usrMapper->mapToDto($user);
        return $this->usrRepository->saveUser($user, $password);
    }
}