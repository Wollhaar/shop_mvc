<?php
declare(strict_types=1);

namespace Shop\Core;

class Helper
{
    public function hash(string $str): string
    {
        return password_hash($str, PASSWORD_ARGON2I);
    }
}