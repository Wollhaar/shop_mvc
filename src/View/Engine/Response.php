<?php
declare(strict_types=1);

namespace View\Engine;

class Response
{
    private $file;

    public function __construct(string $name)
    {
        $this->file = new Template($name);
    }

    public function call()
    {
        return $this->file->getFullPathAddress();
    }
}