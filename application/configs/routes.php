<?php
$routesCfg = array(
    // default controller and action
    'defaultController' => 'index',
    'defaultAction' => 'index',
    // url suffix which is appended at the end of every url
    'urlSuffix' => '/',
    // collection of routes to remap the predefined application flow
    // NOTE: the order is important. More concrete rules must go first
    'routes' => array(
        // drugstores url
        '/drugstores/[any1]/[any2]/' => '/drugstores/index/region/[any1]/city/[any2]/',
    )
);