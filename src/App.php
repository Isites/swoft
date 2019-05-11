<?php

namespace Grace\Swoft;

use Grace\Swoft\Bean\BeanFactory;
use Grace\Swoft\Middleware\HttpMiddleware;
use Grace\Swoft\Middleware\Middleware;



class App {

    private static $firstMiddleware = null;

    public static function getBean($name)
    {
        return BeanFactory::getBean($name);
    }

    public static function hasBean($name) {
        return BeanFactory::hasBean($name);
    }

    public static function init($options = array()) {
        $scans = [];
        if(isset($options['bootScan']) && is_array($options['bootScan'])) {
            $scans = $options['bootScan'];
            unset($options['bootScan']);
        }
        $conf = array_merge([
            'bootScan' => [
                'Grace\Swoft\Aop',
                'Grace\Swoft\Route\Router',
            ],
        ], $options);
        $conf['bootScan'] = array_merge($conf['bootScan'], $scans);
        $conf = array_unique($conf['bootScan']);
        //初始化注解相关
        BeanFactory::init($conf);
        $controllerPath = isset($conf['CONTROLLER_PATH']) ? $conf['CONTROLLER_PATH'] : $_SERVER['REQUEST_URI'];
        $method = isset($conf['REQUEST_METHOD']) ? $conf['REQUEST_METHOD'] : $_SERVER['REQUEST_METHOD'];
        self::add(new HttpMiddleware($controllerPath, $method));
    }

    public static function add($middleware) {
        if($middleware instanceof Middleware) {
            throw new \Exception("middleware must be instanceof Middleware");
        }
        if(self::$firstMiddleware === null) {
            self::$firstMiddleware = $middleware;
        } else {
            $middleware->setNext(self::$firstMiddleware);
            self::$firstMiddleware = $middleware;
        }
    }

    public static function run() {
        if(self::$firstMiddleware !== null) {
            return;
        }
        $response = self::$firstMiddleware->call();
        if(!empty($response)) {
            ob_start();
            echo $response;
            ob_flush();
            die;
        }
    }

}
