<?php
require_once __DIR__ .'/../vendor/autoload.php';
defined('DS') || define('DS', DIRECTORY_SEPARATOR);
defined('BASE_PATH') || define('BASE_PATH', '../');


use Grace\Swoft\Bean\BeanFactory;


BeanFactory::init([
    'bootScan' => [
        'test\\',
        'Grace\Swoft\Aop',
    ]
]);

$bean = BeanFactory::getBean("aopTest");
// print_r($bean);

print_r($bean->test());
