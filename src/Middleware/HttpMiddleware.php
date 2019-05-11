<?php
namespace Grace\Swoft\Middleware;

use Grace\Swoft\Middleware\Middleware;
use Grace\Swoft\Bean\BeanFactory;
use Grace\Swoft\Route\Bean\Collector\ControllerCollector;

class HttpMiddleware extends Middleware {

    private $method;
    private $controllerPath;

    public function __construct($controllerPath, $method) {
        $this->controllerPath = $controllerPath;
        $this->method = $method;
    }

    public function call() {
        $requestMapping = ControllerCollector::getCollector();
        $httpRouter =  BeanFactory::getBean('httpRouter');
        $httpRouter->registerRoutes($requestMapping);

        $httpHandler = $httpRouter->getHandler($this->controllerPath, $this->method);
        $handlerAdaptor = BeanFactory::getBean("httpHandlerAdapter");
        $response = $handlerAdaptor->doHandler($httpHandler);
        return $response;
    }
}