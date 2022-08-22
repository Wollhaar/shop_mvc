<?php
declare(strict_types=1);

namespace Shop\Controller\Backend;

use Shop\Controller\BasicController;
use Shop\Core\{Authenticator, View};

class LoginController implements BasicController
{
    private const TPL = 'BackendLoginView.tpl';

    public function __construct(private View $renderer, private Authenticator $authentication)
    {
    }

    public function view(): void
    {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        if ($username !== '') {
            $this->authentication->authentication($username, $password);
            $loginAttempted = true;
        }
        if ($this->authentication->getAuth()) {
            $this->redirectToBackend();
        }

        $this->renderer->addTemplateParameter($loginAttempted ?? false, 'authentication');
        $this->renderer->addTemplateParameter($this->authentication->getFailed('username'), 'wrong.username');
        $this->renderer->addTemplateParameter($this->authentication->getFailed('password'), 'wrong.password');
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