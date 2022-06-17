<?php declare(strict_types=1);

namespace Shop\Controller;

use Shop\Controller\Data\DataHandler;
use Shop\Core\View;
use Shop\Model\Product;

class ProductController implements BasicController
{
    private const TPL = 'DetailView.tpl';

    private Product $activeProduct;

    private DataHandler $dataHandler;

    private string $output = '<span style="color: brown">Produkt</span><p>';

    private array $collection = [];


    public function __construct()
    {
        $request = $_REQUEST;
        $this->dataHandler = DataHandler::getInstance();

        $this->getProducts();

        $this->activeProduct = $this->collection[(int)($request['id'] ?? 0)] ??
            new Product(0, 'none', 'none', 'none', 0.0);

        $this->build();
    }

    public function view():void
    {
        $renderer = new View();
        $renderer->addTemplateParameter($this->output, 'output');
        $renderer->display(self::TPL);
    }

    private function build():void
    {
        if ($this->activeProduct->getId()) {
            foreach ($this->activeProduct->summarize() as $key => $value) {
                $this->output .= "$key: $value<br/>";
            }
            $this->output .= 'Anzahl: ' . $this->dataHandler->getIntegerData('products', $this->activeProduct->getId(), 'amount') . '</p>';
        }
    }

    private function getProducts():void
    {
        foreach ($this->dataHandler->get('products') as $id => $product) {
            if (empty($product)) {
                continue;
            }
            $this->collection[$id] = new Product($id, $product['name'], $product['size'], $product['category'], (float) $product['price']);
        }
    }
}