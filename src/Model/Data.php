<?php declare(strict_types=1);

namespace Shop\Model;

interface Data {
    public function getId():int;
    public function getName():string;
}