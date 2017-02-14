<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;

use app\services\TwitterApi;
use app\services\TokenValidator;

class TwitterController extends Controller {

    public $defaultAction = 'query';

    public function beforeAction($action){
        if (!parent::beforeAction($action)) return false;
        Yii::$app->response->format = Response::FORMAT_JSON;
        return true;
    }

    public function behaviors(){
        return [];
    }

    public function actions(){
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    public function actionQuery(){

        $request = Yii::$app->request;
        $q = $request->get('q', null);
        $count = $request->get('count', 15);
        if($q === null) return array();

        $tweets = Yii::$app->twitter->searchTweets($q, array('count' => $count));
        foreach ($tweets as $key => $t) $tweets[$key] = $t->toArray(true);

        return array('success' => true, 'data' => $tweets);
    }

    public function actionWordcount(){

        $request = Yii::$app->request;
        $q = $request->get('q', null);
        $count = $request->get('count', 15);
        if($q === null) return array();

        $stopWords = json_decode(file_get_contents(__DIR__."/../models/stop-words.json"));
        $stopWords = '/'.implode('|', $stopWords).'/';

        $tweets = Yii::$app->twitter->searchTweets($q, array('count' => $count));
        $tweetsTotal = count($tweets);
        $words = array();
        $wordsTotal = 0;

        foreach ($tweets as $key => $t) {
            $tokens = $t->getTokens(true);
            foreach ($tokens as $w) {
                if(TokenValidator::is($w, array(TokenValidator::HASHTAG, TokenValidator::MENTIONS, TokenValidator::URL))) continue;
                if(preg_match($stopWords, $w)) continue;
                if(isset($words[$w])) $words[$w]++;
                else $words[$w] = 1;
                $wordsTotal++;
            }
        }

        return array(
            'success' => true,
            'data' => array(
                'words' => $words,
                'totalWords' => $wordsTotal,
                'totalTweets' => $tweetsTotal
            )
        );
    }

    public function actionHashtagcount(){
        $request = Yii::$app->request;
        $q = $request->get('q', null);
        $count = $request->get('count', 15);
        if($q === null) return array();

        $stopWords = json_decode(file_get_contents(__DIR__."/../models/stop-words.json"));
        $stopWords = '/'.implode('|', $stopWords).'/';

        $tweets = Yii::$app->twitter->searchTweets($q, array('count' => $count));
        $tweetsTotal = count($tweets);
        $hashtags = array();
        $hashtagsTotal = 0;

        foreach ($tweets as $key => $t) {
            $tokens = $t->getTokens(true);
            foreach ($tokens as $w) {
                if(!TokenValidator::is($w, array(TokenValidator::HASHTAG, TokenValidator::MENTIONS))) continue;
                if(isset($hashtags[$w])) $hashtags[$w]++;
                else $hashtags[$w] = 1;
                $hashtagsTotal++;
            }
        }

        return array(
            'success' => true,
            'data' => array(
                'hashtags' => $hashtags,
                'hashtagsTotal' => $hashtagsTotal,
                'totalTweets' => $tweetsTotal
            )
        );
    }
}
