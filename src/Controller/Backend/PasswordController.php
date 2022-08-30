<?php
declare(strict_types=1);

namespace Shop\Controller\Backend;

use Shop\Core\PasswordGenerator;
use Shop\Core\View;
use Shop\Model\Dto\UserDataTransferObject;
use Shop\Model\EntityManager\UserEntityManager;
use Shop\Model\Mapper\EmailsMapper;
use Shop\Model\Mapper\UsersMapper;
use Shop\Model\Repository\UserRepository;
use Shop\Service\Session;
use Shop\Service\SymfonyMailerManager;


class PasswordController implements \Shop\Controller\BasicController
{
    private const TPL = 'PasswordView.tpl';

    public function __construct(
        private View $renderer,
        private UserRepository $usrRepository,
        private UserEntityManager $usrEntManager,
        private UsersMapper $usrMapper,
        private EmailsMapper $emailMapper,
        private PasswordGenerator $passGenerator,
        private Session $session,
        private SymfonyMailerManager $mailerManager,
    )
    {
    }

    public function view(): void
    {
        $action = $_GET['action'] ?? null;
        if (!empty($action) && $action !== 'forgotten') {
            $result = $action();
        }

        $this->renderer->addTemplateParameter($action, 'phase');
        $this->renderer->addTemplateParameter($result ?? null, 'result');
    }

    public function display(): void
    {
        $this->renderer->display(self::TPL);
    }

    private function verifyUser(): bool
    {
        $user = $this->usrRepository->findUserByUsername($_POST['email']);

        if ($user instanceof UserDataTransferObject) {
            $mail = [
                'to' => $user->email,
                'message' => 'Link to recover your password',
                'html' => '<p>Link to recover your password</p><a href="/backend/password?action=newPassword&id=' . $user->id . '">Neues Passwort</a> anfragen'
            ];

            return $this->mailerManager->sendMail($this->emailMapper->mapToDto($mail));
        }
        return false;
    }
}