<?php
$params = array_merge(
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'simrs',
    'name' => 'SIMRS',
    'timeZone' => 'Asia/Jakarta',
    'language' => 'id-ID',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-X2NzcmYtY3Ny',
        ],
        'response' => [
            'format' => yii\web\Response::FORMAT_RAW, // Pastikan ini sudah benar
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'defaultRoles' => ['guest'],
        ],
        'saveFile' => [
            'class' => 'app\helpers\SaveFile'
        ],
        'printer' => [
            'class' => 'app\components\Printer',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'manage' => [
            'class' => 'app\components\Manage',
        ],
        'formatter' => [
            'locale' => 'id-ID',
            'defaultTimeZone' => 'Asia/Jakarta', // Gunakan zona waktu Jakarta
            'dateFormat' => 'php:d F Y', // Format tanggal dalam bahasa Indonesia
            'decimalSeparator' => ',',
            'thousandSeparator' => '.',
            'currencyCode' => 'Rp. ',
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
        'i18n' => [
            'translations' => [
                'rbac-admin' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@mdm/admin/messages',
                    'sourceLanguage' => 'id',
                ],
                'yii2-ajaxcrud' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@yii2ajaxcrud/ajaxcrud/messages',
                    'sourceLanguage' => 'id',
                ],
            ],
        ],

    ],

    'modules' => [
        'gridview' =>  [
            'class' => '\kartik\grid\Module'
        ],
        'piechart' => [
            'class' => 'sjaakp/yii2-gcharts'
        ],
        'admin' => [
            'class' => 'mdm\admin\Module',
            'layout' => 'left-menu',
            'controllerMap' => [
                'assignment' => [
                    'class' => 'mdm\admin\controllers\AssignmentController',
                    'userClassName' => 'app\models\User',
                    'idField' => 'id'
                ],
            ],
        ],
        'datecontrol' =>  [
            'class' => 'kartik\datecontrol\Module',
        ],

    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/*',
            'debug/*',
        ]
    ],
    'params' => $params,
];
