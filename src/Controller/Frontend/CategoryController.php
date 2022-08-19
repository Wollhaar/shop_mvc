<?php declare(strict_types=1);

namespace Shop\Controller\Frontend;

use Shop\Controller\BasicController;
use Shop\Core\View;
use Shop\Model\Dto\CategoryDataTransferObject;
use Shop\Model\Repository\{CategoryRepository, ProductRepository, UserRepository};
use Shop\Model\Mapper\CategoriesMapper;
use function PHPUnit\Framework\isNull;

class CategoryController implements BasicController
{
    private const TPL = 'CategoryView.tpl';
    private CategoryDataTransferObject $activeCategory;

    public function __construct(private View $renderer, private CategoryRepository $catRepository, private ProductRepository $prodRepository)
    {
    }

    public function view(): void
    {
        $build = $this->build();
        $activeCategory = false;
        $name = 'All';

        if ($this->activeCategory->id !== 0) {
            $activeCategory = true;
            $name = $this->activeCategory->name;
        }

        $this->renderer->addTemplateParameter($name, 'title');
        $this->renderer->addTemplateParameter($activeCategory, 'activeCategory');
        $this->renderer->addTemplateParameter($build, 'build');
    }

    public function display(): void
    {
        $this->renderer->display(self::TPL);
    }

    private function build(): array
    {
        $activeId = (int)($_REQUEST['id'] ?? 0);

        $this->activeCategory = $this->catRepository->findCategoryById(0);
        if ($activeId) {
            $this->activeCategory = $this->catRepository->findCategoryById($activeId);
            return $this->prodRepository->findProductsByCategoryId($this->activeCategory->id);
        }

        return $this->catRepository->getAll();
    }
}