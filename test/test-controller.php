<?php

require_once __DIR__ .'/../vendor/autoload.php';
defined('DS') || define('DS', DIRECTORY_SEPARATOR);
defined('BASE_PATH') || define('BASE_PATH', '../');


use Grace\Swoft\Bean\BeanFactory;
use Grace\Swoft\Route\Bean\Collector\ControllerCollector;

BeanFactory::init([
    'bootScan' => [
        'test\controllers',
        'Grace\Swoft\Aop',
        'Grace\Swoft\Route\Router',
    ],
    'cached' => true,
]);

$requestMapping = ControllerCollector::getCollector();
$httpRouter =  BeanFactory::getBean('httpRouter');
$httpRouter->registerRoutes($requestMapping);

$httpHandler = $httpRouter->getHandler("/common/nav", "GET");

$handlerAdaptor = BeanFactory::getBean("httpHandlerAdapter");
$response = $handlerAdaptor->doHandler($httpHandler);
print_r($reponse);
