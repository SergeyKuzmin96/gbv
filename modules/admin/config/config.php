<?php
$params = require __DIR__ . '/params.php';
return [
    'components' => [

        'aliases' => [
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@app/modules/admin/views'
                ],
            ],
        ],

    ],
    'params' => [
        $params
    ],
];