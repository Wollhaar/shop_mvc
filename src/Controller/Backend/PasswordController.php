<?php
declare(strict_types=1);

namespace Shop\Controller\Backend;

use Doctrine\ORM\Query\AST\Functions\DateDiffFunction;
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
    private const TTL = 300;

    public function __construct(
        private View $renderer,
        private UserRepository $usrRepository,
        private UserEntityManager $usrEntManager,
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
                'subject' => 'Password recovering',
                'message' => 'Link to recover your password',
                'html' => $user->id
            ];

            $this->session->set($user, 'user');
            $this->session->set(true, 'verified');
            $this->session->set(new \DateTime('now'), 'timeOfVerification');

            return $this->mailerManager->sendMail($this->emailMapper->mapToDto($mail));
        }
        return false;
    }

    private function newPassword(): bool
    {
        $verified = $this->session->get('verified') ?? false;
        $veriTime = $this->session->get('timeOfVerification');

        return $verified && ($this->valuateTime(
            $veriTime->diff(new \DateTime())
            ) < self::TTL);
    }

    private function passwordSet(): bool
    {
        $user = $this->session->get('user');
        $verified = $this->session->get('verified') ?? false;
        $veriTime = $this->session->get('timeOfVerification');

        $valid = $this->valuateTime(
                $veriTime->diff(new \DateTime())
            ) < self::TTL;

        if ($user && $verified && $valid) {
            $newPassword = $_POST['password'] ?? '';
            if ($newPassword !== '') {
                return $this->usrEntManager->savePassword(
                    $user,
                    $this->passGenerator->hash($newPassword)
                );
            }
        }

        return false;
    }

    private function valuateTime(\DateInterval $dateDiff): int
    {
        $seconds = 0;
        $seconds += $dateDiff->y * 12 * 30 * 24 * 60 * 60;
        $seconds += $dateDiff->m * 30 * 24 * 60 * 60;
        $seconds += $dateDiff->d * 24 * 60 * 60;
        $seconds += $dateDiff->h * 60 * 60;
        $seconds += $dateDiff->i * 60;
        $seconds += $dateDiff->s;
        return $seconds;
    }
}