<?php
declare(strict_types=1);

namespace Shop\Core;

use Shop\Model\Repository\UserRepository;
use Shop\Service\Session;

class Authenticator
{
    private bool $auth;
    private array $failed = [
        'username' => false,
        'password' => false
    ];

    public function __construct(private Session $session, private UserRepository $userRepository)
    {
    }

    public function authentication(string $username, string $password): void
    {
        $user = $this->userRepository->findUserByUsername($username);

        $this->failed['username'] = true;
        if ($user !== null) {
            $this->auth = password_verify(trim($password), $user->passwordHash);
            $this->failed['username'] = !$user->id;
            $this->failed['password'] = !$this->auth;
        }

        $this->session->set($this->auth ?? null, 'auth');
        $this->session->set($user, 'user');
    }

    /**
     * @return bool
     */
    public function getAuth(): bool
    {
        if (empty($this->auth) || $this->auth !== true) {
            $this->auth = $this->session->get('auth') ?? false;
        }
        return $this->auth;
    }

    /**
     * @param string $property
     * @return bool
     */
    public function getFailed(string $property): bool
    {
        return $this->failed[$property];
    }

    /**
     * @return Session
     */
    public function getSession(): Session
    {
        return $this->session;
    }
}