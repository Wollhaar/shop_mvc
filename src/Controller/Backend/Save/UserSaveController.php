<?php
declare(strict_types=1);

namespace Shop\Controller\Backend\Save;

use Shop\Controller\BasicController;
use Shop\Core\View;
use Shop\Model\Dto\UserDataTransferObject;
use Shop\Model\Repository\{CategoryRepository, ProductRepository, UserRepository};

class UserSaveController implements BasicController
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

        $this->renderer->addTemplateParameter('User', 'title');
        $this->renderer->addTemplateParameter($user, 'user');
    }

    public function display(): void
    {
        $this->renderer->display(self::TPL);
    }

    private function build(): UserDataTransferObject
    {
        $product = $_REQUEST['user'];
        return $this->usrRepository->saveUser($product);
    }
}