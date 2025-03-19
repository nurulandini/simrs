<?php

return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'schemaMap' => [
                'mysql' => SamIT\Yii2\MariaDb\Schema::class
            ],
            'dsn' => 'mysql:host=localhost;dbname=yii2',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
        'mailer' => [
            /*
                change from swiftmailer to symfonymailer
                https://symfony.com/doc/5.4/mailer.html
                https://github.com/yiisoft/yii2-symfonymailer
                https://github.com/yiisoft/mailer-symfony
            */
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            'useFileTransport' => false,
            'transport' => [
                'scheme' => 'smtp',
                'host' => '',
                'username' => '',
                'password' => '',
                'port' => 0,
                'options' => ['ssl' => true],
            ],
        ],
        'storageCsr' => [
            'class' => 'bevin1984\MinioClient',
            'key' => '',
            'secret' => '',
            'bucket' => '',
            'region' => '',
            'endpoint' => '',
            // 'version' => 'latest',
            // 'baseUrl' => 'your-base-url',
            // 'prefix' => 'your-prefix',
            // 'options' => [],
        ],
    ],
];
