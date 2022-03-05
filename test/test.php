<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once 'Users.php';

$relate = [
    ['course as on cc.uid = bb.id','left']
];

$res = test\Users::query()->alias('u')->field('u.*')
    ->relate(
        [
            ['course c','u.id = c.user_id']
        ]
    )
    ->where(
    [
        ['u.id','=','1'],
        ['u.name','like','%lisi%','OR'],
    ]
)->orderBy('id')->get();



$res = \test\Users::query()->fetchSql(false)->getListForPage(
    [
        ['u.id','=', 1]
    ],'c.*',[
        'alias' => 'u',
        'relate' => [
            ['course c','u.id = c.user_id']
        ]
],'u.id desc',1,2
);

var_dump($res);






