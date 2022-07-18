<?php
declare(strict_types=1);

namespace Shop\Core;

use Shop\Model\Repository\UserRepository;
use Shop\Service\Session;

class Authenticator
{
    private Session $session;
    private UserRepository $userRepository;
    private bool $auth;

    public function __construct(Session $session, UserRepository $userRepository)
    {
        $this->session = $session;
        $this->userRepository = $userRepository;

        $this->auth = $this->session->get('user')['auth'] ?? false;
    }

    public function authentication(string $username): array
    {
        $request = $_REQUEST;
        $user = $this->userRepository->findUserByUsername($username);

        $password = $this->userRepository->getPasswordByUser($user);
        $password2 = $request['password'] ?? false;

        $this->auth = $password === $password2;
        $authenticated = ['username' => (bool) $user->id, 'password' => $this->auth];

        $this->session->set(['auth' => $this->auth, 'data' => $user], 'user');
        return $authenticated;
    }

    /**
     * @return bool
     */
    public function getAuth(): bool
    {
        return $this->auth;
    }

    /**
     * @return Session
     */
    public function getSession(): Session
    {
        return $this->session;
    }
}