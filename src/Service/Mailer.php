<?php
declare(strict_types=1);

namespace Shop\Service;

use Symfony\Component\Mailer\Transport\Transports;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\RawMessage;

class Mailer
{
    public function __construct(private Transports $transports, private RawMessage $raw)
    {
    }

    public function sendMail(Email $mail): bool
    {
        $sent = $this->transports->send($this->raw);
        return is_string($sent->getMessageId());
    }
}