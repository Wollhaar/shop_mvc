<?php declare(strict_types=1);

namespace Shop\Controller\Frontend;

use Shop\Controller\BasicController;
use Shop\Core\View;
use Shop\Model\Repository\{CategoryRepository, ProductRepository};

class DetailController implements BasicController
{

    private const TPL = 'DetailView.tpl';

    private ProductRepository $prodRepository;

    private View $renderer;


    public function __construct(View $renderer, CategoryRepository $catRepository, ProductRepository $prodRepository)
    {
        $this->renderer = $renderer;
        $this->prodRepository = $prodRepository;
    }

    public function view(): void
    {
        $request = $_REQUEST;
        $activeId = (int) ($request['id'] ?? 0);
        $activeProduct = $this->prodRepository->findProductById($activeId);

        $this->renderer->addTemplateParameter($activeProduct, 'product');
    }

    public function display(): void
    {
        $this->renderer->display(self::TPL);
    }
}