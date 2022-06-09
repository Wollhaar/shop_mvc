<?php declare(strict_types=1);

namespace Controller;

class HomeController
{
    private const page = 'home';

    private string $output = '';

    public function __construct()
    {
        $request = $_REQUEST;
        $this->activePage = $request['page'] ?? self::page;
        $this->id = (int) ($request['id'] ?? 0);
    }

    public function view():void
    {
        $test = $this->output;
        include ROOT_PATH . '/src/View/home.php';
    }
}