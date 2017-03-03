<?php

/* @var $this yii\web\View */

$this->title = 'Arquitetura Web';
$baseUrl = Yii::$app->getUrlManager()->getBaseUrl();
$this->registerJsFile($baseUrl.'/js/Application.js');
$this->registerJsFile($baseUrl.'/js/app/app.js');
?>

<div id="viewport" class="tab-content">

    <div role="tabpanel" class="tab-pane active" id="home">
        <div class="page-header">
          <h2>Trabalho de Arquitetura e Tecnologias de Sistemas Web
              <br>
              <small>Mineração de dados do Twitter</small>
          </h2>
        </div>


        <div>
            <ul>
                <li><h4><strong>Instituição</strong>: Universiade Federal de Roraima</h4></li>
                <li><h4><strong>Aluno</strong>: Edwino Alberto Lopes Stein</h4></li>
                <li><h4><strong>Matrícula</strong>: 1201324411</h4></li>
                <li><h4><strong>Professor</strong>: Leandro Nelinho Balico</h4></li>
            </ul>
        </div>
    </div>

    <!-- Query Tab -->
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

    <!-- Wordcounter Tab -->
    <div role="tabpanel" class="tab-pane" id="wordcounter">
        <div class="page-header">
          <h2>Análise por contagem de palavras</h2>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="query"></div>
            </div>
            <div class="panel-heading report">
                Total de <strong class="word-counter">0</strong> palavra(s), a partir de <strong class="tweet-counter">0</strong> tweet(s)
            </div>
            <div class="panel-body message">Message</div>
            <div class="panel-body chart"></div>
            <table class="table table-hover table-striped results">
                <thead>
                    <tr>
                        <th width="75%">Palavra</th>
                        <th width="25%">Quantidade</th>
                    </tr>
                </thead>
                <tbody>
                    <tr id="wordcounter-model">
                        <td class="word">Key</td>
                        <td class="amount">0</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div><!-- FIM Wordcounter Tab -->

    <!-- Hashtagcounter Tab -->
    <div role="tabpanel" class="tab-pane" id="hashcounter">
        <div class="page-header">
          <h2>Análise por contagem de hashtags e menções</h2>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="query"></div>
            </div>
            <div class="panel-heading report">
                Total de <strong class="hashtags-counter">0</strong> hashtag(s), a partir de <strong class="tweet-counter">0</strong> tweet(s)
            </div>
            <div class="panel-body message">Message</div>
            <div class="panel-body chart"></div>
            <table class="table table-hover table-striped results">
                <thead>
                    <tr>
                        <th width="75%">#Hastag/@Menção</th>
                        <th width="25%">Quantidade</th>
                    </tr>
                </thead>
                <tbody>
                    <tr id="hashcounter-model">
                        <td class="hashtag">Key</td>
                        <td class="amount">0</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div><!-- FIM Hashtagcounter Tab -->

    <!-- Cooccurrences Tab -->
    <div role="tabpanel" class="tab-pane" id="cooccurrences">
        <div class="page-header">
          <h2>Análise por co-ocorrência de palavras</h2>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="query"></div>
            </div>
            <div class="panel-heading report">
                Total de <strong class="word-counter">0</strong> palavra(s), a partir de <strong class="tweet-counter">0</strong> tweet(s)
            </div>
            <div class="panel-body message">Message</div>
            <ul class="list-group results">
                <li id="cooccurrences-model" class="list-group-item collapsed">
                    <div class="result-header">
                        Termo: "<strong class="word">word</strong>" |
                        Co-ocorrências: <strong class="cooccurrences-amount">amount</strong> |
                        Palavas: <strong class="word-amount">amount</strong>
                    </div>
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th width="75%">Palavra</th>
                                <th width="25%">Quantidade</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr id="cooccurrences-model-row">
                                <td class="word">Key</td>
                                <td class="amount">0</td>
                            </tr>
                        </tbody>
                    </table>
                </li>
            </ul>
        </div>
    </div><!-- FIM Cooccurrences Tab -->

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
