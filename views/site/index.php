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
        <div class="page-header">
          <h2>Buscar por algum tema</h2>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="query"></div>
            </div>
            <div class="panel-heading report">
                Total de <strong class="counter">0</strong> tweet(s)
            </div>
            <div class="panel-body message">
                <h1>Nenhum resultado</h1>
            </div>
            <ul class="list-group results">
                <li class="list-group-item">
                    <h4>Tweet text 1</h4>
                </li>
                <li class="list-group-item">
                    <h4>Tweet text 2</h4>
                </li>
                <li class="list-group-item">
                    <h4>Tweet text 3</h4>
                </li>
            </ul>
        </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="wordcounter">
        wordcounter
    </div>
</div>

<div id="query-input-abstract">
    <form>
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Buscar...">
            <span class="input-group-btn">
                <button class="btn btn-primary" type="submit">
                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                </button>
            </span>
        </div>
    </form>
</div>
