<?php
declare(strict_types=1);

namespace Shop\Model\Dto;

class EmailDataTransferObject
{
    public function __construct(
        public readonly string $to,
        public readonly string $from,
        public readonly array $cc,
        public readonly array $bcc,
        public readonly string $subject,
        public readonly string $message,
        public readonly string $html,
    )
    {}
}