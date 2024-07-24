<?php

/** 
 * @var yii\web\View $this views components instance
 * @var yii\mail\BaseMessage $message the message being composed
 * @var string $content main views render result
 */

$this->beginPage();
$this->beginBody();
echo $content;
$this->endBody();
$this->endPage();
