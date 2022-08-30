<?php
declare(strict_types=1);

namespace Shop\Service;

use Shop\Model\Dto\EmailDataTransferObject;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;
use Symfony\Component\Mime\RawMessage;
use Symfony\Component\Mailer\Transport\Transports;
use Symfony\Component\Mime\Email;

class SymfonyMailerManager
{
    private Mailer $mailer;
    private Email $email;

    public function __construct()
    {
        $this->mailer = new Mailer(new Transports(['main' => new EsmtpTransport('localhost', 1025)]), new RawMessage());
    }


    public function sendMail(EmailDataTransferObject $emailDTO):bool
    {
        $this->createMail($emailDTO);
        return $this->mailer->sendMail($this->email);
    }

    private function createMail(EmailDataTransferObject $emailDTO)
    {
        $this->email = (new Email())
            ->from('david.goraj@cec.valantic.com')
            ->to($emailDTO->to)
            ->subject($emailDTO->subject)
            ->text($emailDTO->message)
            ->html($emailDTO->html); // '<p>See Twig integration for better HTML integration!</p>'
        foreach ($emailDTO->cc as $email) {
            $this->email->addCc($email);
        }
        foreach ($emailDTO->bcc as $email) {
            $this->email->addBcc($email);
        }
    }
}
