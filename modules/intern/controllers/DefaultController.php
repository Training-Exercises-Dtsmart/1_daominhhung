<?php

namespace app\modules\intern\controllers;

use app\controllers\Controller;

class DefaultController extends Controller
{
    public function actionIndex(): string
    {
        return "default";
    }
}