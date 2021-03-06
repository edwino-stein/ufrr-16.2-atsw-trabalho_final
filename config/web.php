<?php

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'twitter'],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'iPdgPYFKg9SK46AvY_6r8XN4okGnZdpa',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'twitter' => [
            'class' => app\services\TwitterApi::class,
            'consumerKey' => 'CdRW6cTOwy6HHu4CbgZ1JR3eS',
            'consumerSecret' => 'rKHK1LPnnZ1lgvaOh6sen7D4ldbSqlfbcIXINzhqg3JQmrmwiJ',
            'accessToken' => '796543085786308608-Bi4A9VM4YtJUUzpxvK19Luq06PR7BTY',
            'accessTokenSecret' => 'FhvnwrcJXtUDB1ovpyNW4X3AIzaTcPCYZjdOM6jMqmKPZ',
            'tweetModelClass' => app\models\Tweet::class
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [],
        ]
    ],
    'params' => ['adminEmail' => 'edwino.stein@ufrr.br'],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
