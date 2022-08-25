<?php declare(strict_types=1);

namespace Shop\Controller\Frontend;

use Shop\Controller\BasicController;
use Shop\Core\View;
use Shop\Model\Repository\{CategoryRepository, ProductRepository};

class DetailController implements BasicController
{
    private const TPL = 'DetailView.tpl';

    public function __construct(private View $renderer, private ProductRepository $prodRepository)
    {
    }

    public function view(): void
    {
        $activeId = (int) ($_GET['id'] ?? 0);
        $activeProduct = $this->prodRepository->findProductById($activeId);

        $this->renderer->addTemplateParameter($activeProduct, 'product');
    }

    public function display(): void
    {
        $this->renderer->display(self::TPL);
    }
}