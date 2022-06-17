<?php
declare(strict_types=1);

namespace ShopTest;

use PHPUnit\Framework\TestCase;
use Shop\Controller\Data\DataHandler;
use Shop\Model\Product;

include_once 'vars.php';

class DataHandlerTest extends TestCase
{
    public function testGetIntegerData()
    {
        $handler = DataHandler::getInstance();
        self::assertSame(200, $handler->getIntegerData('products', 1, 'amount'));
    }

    public function testGetData()
    {
        $handler = DataHandler::getInstance();
        self::assertInstanceOf(Product::class, $handler->getData('products', 1));
    }

    public function testGet()
    {
        $handler = DataHandler::getInstance();
        self::assertSame([], $handler->get(''));
    }
}