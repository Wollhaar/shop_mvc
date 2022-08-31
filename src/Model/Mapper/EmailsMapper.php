<?php
declare(strict_types=1);

namespace Shop\Model\Mapper;

use Shop\Model\Dto\EmailDataTransferObject;

class EmailsMapper
{
    public function mapToDto(array $email): EmailDataTransferObject
    {
        return new EmailDataTransferObject(
            $email['to'],
            $email['subject'],
            $email['message'],
            $email['html']
        );
    }
}