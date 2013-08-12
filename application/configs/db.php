<?php
$dbCfg = array(
    'driver' => 'mysqli',
    'dev' => array(
        'host' => 'localhost',
        'login' => 'root',
        'password' => 'root',
        'database' => 'leptaden'
    ),
	'dev2' => array(
        'host' => 'localhost',
        'login' => 'root',
        'password' => '',
        'database' => 'leptaden'
	),
    'test' => array(
        'host' => 'mysql.hostinger.com.ua',
        'login' => 'u765017674_lepta',
        'password' => 'leptaden123',
        'database' => 'u765017674_lepta'
    ),
    'production' => array(
        'host' => 'localhost',
        'login' => '',
        'password' => '',
        'database' => ''
    )
);