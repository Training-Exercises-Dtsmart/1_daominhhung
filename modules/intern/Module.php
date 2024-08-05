<?php

namespace app\modules\intern;

use yii\base\Module as BaseModule;

class Module extends BaseModule
{
    public function init()
    {
        $this->defaultRoute = "product";
        parent::init();
    }
}