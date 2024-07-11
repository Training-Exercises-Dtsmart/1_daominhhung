<?php
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $content string */

$this->beginPage();
?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="wrapper">
    <header>
        <h1>Xin chào</h1>
    </header>
    <main>
        <?= $content ?>
    </main>
    <footer>
        <p>Email này được gửi từ <?= Yii::$app->name ?></p>
    </footer>
</div>
<?php $this->endBody() ?>
</body>
</html>

<?php $this->endPage() ?>
