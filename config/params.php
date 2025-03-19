<?php
return [
    // kartik bootstrap verison
    'bsVersion' => '4.x',

    // common site parameters
    'site' => 'https://dev.pemkomedan.go.id',
    'adminEmail' => 'helpdesk.bappedamedan@gmail.com',
    'supportEmail' => 'helpdesk.bappedamedan@gmail.com',
    'senderEmail' => 'helpdesk.bappedamedan@gmail.com',
    'senderName' => 'Bappeda Kota Medan',
    'user.passwordResetTokenExpire' => 3600,
    'user.passwordMinLength' => 8,
    'softwareBy' => 'Bappeda Kota Medan',
    'version' => '1.0.0-'. Yii::getVersion(),

    //for API purpose
    'useHttpBasicAuth' => false,
    'useHttpBearerAuth' => true,
    'useQueryParamAuth' => false,
    'useRateLimiter' => false,

    // //for adminlte3
    // 'adminEmail' => 'admin@example.com',
    // 'hail812/yii2-adminlte3' => [
    //     'pluginMap' => [
    //         'sweetalert2' => [
    //             'css' => 'sweetalert2-theme-bootstrap-4/bootstrap-4.min.css',
    //             'js' => 'sweetalert2/sweetalert2.min.js'
    //         ],
    //         'toastr' => [
    //             'css' => ['toastr/toastr.min.css'],
    //             'js' => ['toastr/toastr.min.js']
    //         ],
    //     ]
    // ]
];
