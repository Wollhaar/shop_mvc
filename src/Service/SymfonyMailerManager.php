<?php
declare(strict_types=1);

namespace Shop\Service;

use Shop\Model\Dto\EmailDataTransferObject;
use Symfony\Component\Mime\Email;

class SymfonyMailerManager
{
    public function __construct(private Mailer $mailer)
    {}

    public function sendMail(EmailDataTransferObject $emailDTO):bool
    {
        $email = $this->createMail($emailDTO);
        return $this->mailer->sendMail($email);
    }

    private function createMail(EmailDataTransferObject $emailDTO): Email
    {
        return (new Email())
            ->from('david.goraj@cec.valantic.com')
            ->to($emailDTO->to)
            ->subject($emailDTO->subject)
            ->text($emailDTO->message)
            ->html('<p>Link to recover your password:</p><a href="/backend/password?action=newPassword&id=' .
                $emailDTO->html . '">Neues Passwort</a> anfragen'); // '<p>See Twig integration for better HTML integration!</p>'
    }
}
