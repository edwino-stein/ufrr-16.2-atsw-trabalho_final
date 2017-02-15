<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Arquitetura Web',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-default navbar-static-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right', 'id' => 'tab-panel'],
        'items' => [
            ['label' => 'Inicio', 'linkOptions' => ['data-view' => '#home'], 'active' => true],
            ['label' => 'Buscar', 'linkOptions' => ['data-view' => '#query']],
            ['label' => 'Word Counter', 'linkOptions' => ['data-view' => '#wordcounter']],
            ['label' => 'Hashtag Counter', 'linkOptions' => ['data-view' => '#hashcounter']],
            ['label' => 'Co-ocorrência', 'linkOptions' => ['data-view' => '#cooccurrences']],
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">Edwino Stein - <?= date('Y') ?></p>

        <p class="pull-right">Arquitetura Web</p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
