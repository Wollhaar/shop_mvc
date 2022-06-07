<?php declare(strict_types=1);

namespace View\Engine;

class Template
{
    private const path = ROOT_PATH . '/src/View/Resources/Templates/';
    private const format = '.php';

    private $filename;

    public function __construct(string $name)
    {
        $this->filename = $name;
    }

    /**
     * @return string
     */
    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * @return string
     */
    public function getFullPathAddress(): string
    {
        return self::path .$this->filename . self::format;
    }
}