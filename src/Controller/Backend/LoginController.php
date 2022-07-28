<?php
declare(strict_types=1);

namespace Shop\Controller\Backend;

use Shop\Controller\BasicController;
use Shop\Core\{Authenticator, View};
use Shop\Model\Repository\{CategoryRepository, ProductRepository, UserRepository};
use Shop\Model\Mapper\{CategoriesMapper, ProductsMapper, UsersMapper};

class LoginController implements BasicController
{
    private const TPL = 'BackendLoginView.tpl';
    private Authenticator $authentication;
    private UserRepository $usrRepository;
    private View $renderer;

    public function __construct(View $view, CategoryRepository $catRepository, ProductRepository $prodRepository, UserRepository $usrRepository, CategoriesMapper $catMapper, ProductsMapper $prodMapper, UsersMapper $usrMapper, Authenticator $authenticator)
    {
        $this->renderer = $view;
        $this->authentication = $authenticator;
        $this->usrRepository = $usrRepository;
    }

    public function view(): void
    {
        $username = $_REQUEST['username'] ?? '';
        $authFailed = false;
        if ($username !== '') {
            $authFailed = $this->authentication->authentication($username);
        }
        if ($this->authentication->getAuth()) {
            $this->redirectToBackend();
        }

        $this->renderer->addTemplateParameter($this->usrRepository->findUserByUsername($username), 'user');
        $this->renderer->addTemplateParameter($authFailed, 'authentication');
    }

    public function display(): void
    {
        $this->renderer->display(self::TPL);
    }

    private function redirectToBackend(): void
    {
        $queryInfo = isset($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : '';
        header('Location: /backend' . $queryInfo);
    }
}