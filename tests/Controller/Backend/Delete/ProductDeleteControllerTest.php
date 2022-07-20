<?php
declare(strict_types=1);

namespace ShopTest\Controller\Backend\Delete;

use PHPUnit\Framework\TestCase;
use Shop\Controller\Backend\Delete\ProductDeleteController;
use Shop\Core\View;
use Shop\Model\Mapper\{CategoriesMapper, ProductsMapper, UsersMapper};
use Shop\Model\Repository\{CategoryRepository, ProductRepository, UserRepository};

class ProductDeleteControllerTest extends TestCase
{
    public function testView()
    {
        $_REQUEST['id'] = 11;

        $view = new View();
        $controller = new ProductDeleteController($view,
            new CategoryRepository(new CategoriesMapper()),
            new ProductRepository(new ProductsMapper()),
            new UserRepository(new UsersMapper()),
        );
        $controller->view();
        $results = $view->getParams();

        self::assertSame('Products', $results['title']);
        self::assertSame(1, $results['products'][1]->id);
        self::assertSame('shirt no.1', $results['products'][1]->name);
        self::assertSame(2, $results['products'][2]->id);
        self::assertSame('HSV - Home-Jersey', $results['products'][2]->name);
        self::assertSame(3, $results['products'][3]->id);
        self::assertSame('Hoodie - Kapuzenpulli', $results['products'][3]->name);
        self::assertSame(4, $results['products'][4]->id);
        self::assertSame('Denim', $results['products'][4]->name);
        self::assertSame(5, $results['products'][5]->id);
        self::assertSame('Bandshirt - Outkast', $results['products'][5]->name);
        self::assertSame(6, $results['products'][6]->id);
        self::assertSame('Jogger', $results['products'][6]->name);
        self::assertSame(7, $results['products'][7]->id);
        self::assertSame('plain white', $results['products'][7]->name);
        self::assertSame(8, $results['products'][8]->id);
        self::assertSame('Strickjacke - schwarz,braun,grau', $results['products'][8]->name);
    }
}