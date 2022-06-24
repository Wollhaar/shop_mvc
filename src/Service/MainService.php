<?php declare(strict_types=1);

namespace Shop\Service;

use Shop\Controller\BasicController;
use Shop\Core\View;

class MainService
{
    public BasicController $controller;

    private string $page;


    public function __construct()
    {
        $request = $_REQUEST;
        $this->page = $request['page'] ?? 'home';
    }

    public function action(): void
    {
        $this->setController();
        $this->controller->view();
    }

    public function getView(): View
    {
        return $this->controller->getView();
    }

    public function getController(): BasicController
    {
        return $this->controller;
    }

    private function setController(): void
    {
        require_once __DIR__ . '/../../helper.php';

        $controller = class_search($this->page);
        $this->controller = new $controller(new View());
    }
}