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

    <div role="tabpanel" class="tab-pane" id="query"> <!-- Query Tab -->
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
            <div class="panel-body message"></div>
            <ul class="list-group results">
                <li id="tweet-model" class="list-group-item">
                    <div class="container-fluid tweet">
                        <div class="col-xs-12 meta">
                            <div class="col-xs-7 user-info">
                                <div class="thumbnail avatar">
                                    <img src="" >
                                </div>
                                <div class="user">
                                    <p class="name"></p>
                                    <p class="nick"></p>
                                </div>
                            </div>
                            <div class="col-xs-5 info">
                                <div class="date"></div>
                                <div class="indicators">
                                    <span class="likes">
                                        <i class="glyphicon glyphicon-heart"></i>
                                        <span class="counter"></span>
                                    </span>
                                    <span class="retweeties">
                                        <i class="glyphicon glyphicon-retweet"></i>
                                        <span class="counter"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 data">
                            <div class="col-xs-12 text"></div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div> <!-- FIM Query Tab -->

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
