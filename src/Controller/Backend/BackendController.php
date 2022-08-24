<?php
declare(strict_types=1);

namespace Shop\Controller\Backend;

use Shop\Controller\BasicController;
use Shop\Core\Authenticator;
use Shop\Core\View;
use Shop\Model\Dto\UserDataTransferObject;
use Shop\Model\Repository\{CategoryRepository, ProductRepository, UserRepository};
use Shop\Model\Mapper\{CategoriesMapper, ProductsMapper, UsersMapper};
use Shop\Service\Session;

class BackendController implements BasicController
{
    private const TPL = 'BackendView.tpl';
    private Session $session;

    public function __construct(private View $renderer, private Authenticator $authenticator)
    {
        $this->session = $this->authenticator->getSession();
    }

    public function view(): void
    {
        $user = $this->buildUser();

        $this->renderer->addTemplateParameter('Dashboard', 'title');
        $this->renderer->addTemplateParameter('Welcome ' . $user->username, 'subtitle');
        $this->renderer->addTemplateParameter($user, 'user');
    }

    public function display(): void
    {
        $this->renderer->display(self::TPL);
    }

    private function buildUser(): UserDataTransferObject
    {
        $user = $this->session->get('user');
        if (is_null($user) || !$this->authenticator->getAuth()) {
            header('Location: /backend/login');
        }

        return $user;
    }
}