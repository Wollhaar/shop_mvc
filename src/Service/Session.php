<?php
declare(strict_types=1);

namespace Shop\Service;

class Session
{
    private array $session = [];
    private int $active;

    public function __construct(bool $test = false)
    {
        $this->active = session_status();
        if ($test) {
            $this->session['auth'] = true;
            return;
        }
        session_start();
        $this->active = session_status();
        if ($this->active) {
            $this->session = $_SESSION;
        }
    }

    public function logout(): void
    {
        $_SESSION = [];
        $this->session = [];
        session_destroy();
        session_start();
    }

    public function get(string $data)
    {
        return $this->session[$data] ?? null;
    }

    public function set($data, string $param): void
    {
        $this->session[$param] = $data;
        if ($this->active === PHP_SESSION_ACTIVE) {
            $_SESSION = array_merge($_SESSION, $this->session);
        }
    }

    public function status(): int
    {
        return $this->active;
    }
}