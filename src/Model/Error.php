<?php
declare(strict_types=1);

namespace Shop\Model;

class Error extends \Exception
{
    public const code = [
        101 => ['message' => 'Class not exists'],
        102 => ['message' => 'Category not found'],
        103 => ['message' => 'Product not found'],
        404 => ['message' => 'Page not found'],
    ];

    private int $number;
    private string $issue;


    public function __construct(int $number)
    {
        parent::__construct(self::code[$number]['message'], $number);
        $this->number = $number;
    }

    /**
     * @param string
     */
    public function setIssue(string $issue): void
    {
        $this->issue = $issue;
    }

    /**
     * @return int
     */
    public function getNumber(): int
    {
        return $this->number;
    }

    /**
     * @return string
     */
    public function getIssue(): string
    {
        return $this->issue;
    }
}