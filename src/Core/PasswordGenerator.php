<?php
declare(strict_types=1);

namespace Shop\Core;

class PasswordGenerator
{
    public const KEY_ALGO = PASSWORD_ARGON2I;

    public function hash(string $str): string
    {
        return password_hash($str, self::KEY_ALGO);
    }
}