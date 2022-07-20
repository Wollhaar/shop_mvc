<?php
declare(strict_types=1);

namespace Shop\Controller\Backend\Profile;

use Shop\Controller\BasicController;
use Shop\Core\View;
use Shop\Model\Dto\UserDataTransferObject;
use Shop\Model\Repository\CategoryRepository;
use Shop\Model\Repository\ProductRepository;
use Shop\Model\Repository\UserRepository;

class UserProfileController implements BasicController
{
    private const TPL = 'UserProfileView.tpl';
    private View $renderer;
    private UserRepository $usrRepository;

    public function __construct(View $renderer, CategoryRepository $catRepository, ProductRepository $prodRepository, UserRepository $usrRepository)
    {
        $this->renderer = $renderer;
        $this->usrRepository = $usrRepository;
    }

    public function view(): void
    {
        $user = $this->build();
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

    private function build(): UserDataTransferObject
    {
        $id = (int)($_REQUEST['id'] ?? 0);
        return $this->usrRepository->findUserById($id);
    }
}