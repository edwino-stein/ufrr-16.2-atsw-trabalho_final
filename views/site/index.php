<?php

/* @var $this yii\web\View */

$this->title = 'Arquitetura Web';
$baseUrl = Yii::$app->getUrlManager()->getBaseUrl();
$this->registerJsFile($baseUrl.'/js/Application.js');
$this->registerJsFile($baseUrl.'/js/app/app.js');
?>

<div id="viewport" class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="home">
        Home
    </div>
    <div role="tabpanel" class="tab-pane" id="query">
        query
    </div>
    <div role="tabpanel" class="tab-pane" id="wordcounter">
        wordcounter
    </div>
</div>
