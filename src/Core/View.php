<?php declare(strict_types=1);

namespace Shop\Core;

use Smarty;

class View
{
    private Smarty $renderer;

    private array $params = [];


    public function __construct()
    {
        $this->renderer = new Smarty();
    }

    public function addTemplateParameter(mixed $param, string $name): void
    {
        $this->params[$name] = $param;
    }

    public function addTemplateParameterObject($object, string $name): void
    {
        $this->params[$name] = $object->summarize();
    }

    public function addTemplateParameterObjectArray(array $params, string $name, array $attrList = []): void
    {
        foreach ($params as $key => $object) {
            $data = $object->summarize();
            if (!empty($attrList)) {
                $this->filterParams($data, $attrList);
            }
            $params[$key] = $data;
        }
        $this->params[$name] = $params;
    }

    public function display(string $template): void
    {
        $this->renderer->assign($this->params);
        $this->renderer->display($template);
    }

    public function getParams(): array
    {
        return $this->params;
    }

    private function filterParams(array $data, $attrList): array
    {
        $newData = [];
        foreach ($attrList as $attr) {
            $newData[$attr] = $data[$attr];
        }
        return $newData;
    }
}