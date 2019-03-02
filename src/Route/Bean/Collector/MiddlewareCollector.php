<?php

namespace Grace\Swoft\Route\Bean\Collector;

use Grace\Swoft\Route\Bean\Annotation\Middleware;
use Grace\Swoft\Route\Bean\Annotation\Middlewares;
use Grace\Swoft\Bean\CollectorInterface;

/**
 * Middleware collector
 */
class MiddlewareCollector implements CollectorInterface
{
    /**
     * @var array
     */
    private static $middlewares = [];

    /**
     * @param string $className
     * @param null   $objectAnnotation
     * @param string $propertyName
     * @param string $methodName
     * @param null   $propertyValue
     * @return void
     */
    public static function collect(
        $className,
        $objectAnnotation = null,
        $propertyName = '',
        $methodName = '',
        $propertyValue = null
    ) {
        if ($objectAnnotation instanceof Middleware) {
            self::collectMiddleware($className, $methodName, $objectAnnotation);
        } elseif ($objectAnnotation instanceof Middlewares) {
            self::collectMiddlewares($className, $methodName, $objectAnnotation);
        }
    }

    /**
     * 暂时未做对中间件的支持
     * @param array $data
     * @return boolean
     */
    public static function init($data) {
        return false;
    }

    /**
     * @return array
     */
    public static function getCollector()
    {
        return self::$middlewares;
    }

    /**
     * collect middlewares
     *
     * @param string      $className
     * @param string      $methodName
     * @param Middlewares $middlewaresAnnotation
     */
    private static function collectMiddlewares(
        string $className,
        string $methodName,
        Middlewares $middlewaresAnnotation
    ) {
        $classMiddlewares = [];
        foreach ($middlewaresAnnotation->getMiddlewares() as $middleware) {
            if ($middleware instanceof Middleware) {
                $classMiddlewares[] = $middleware->getClass();
            }
        }
        $classMiddlewares = array_unique($classMiddlewares);

        if (! empty($methodName)) {
            $scanMiddlewares = !empty(self::$middlewares[$className]['middlewares']['actions'][$methodName]) ? self::$middlewares[$className]['middlewares']['actions'][$methodName] : [];
            self::$middlewares[$className]['middlewares']['actions'][$methodName] = array_unique(array_merge($classMiddlewares,$scanMiddlewares));
        } else {
            $scanMiddlewares = !empty(self::$middlewares[$className]['middlewares']['group']) ? self::$middlewares[$className]['middlewares']['group'] : [];
            self::$middlewares[$className]['middlewares']['group'] = array_unique(array_merge($classMiddlewares, $scanMiddlewares));
        }
    }

    /**
     * collect middleware
     *
     * @param string     $className
     * @param string     $methodName
     * @param Middleware $middlewareAnnotation
     */
    private static function collectMiddleware($className, $methodName, $middlewareAnnotation)
    {
        $middlewares = [
            $middlewareAnnotation->getClass(),
        ];

        if (! empty($methodName)) {
            $scanMiddlewares = !empty(self::$middlewares[$className]['middlewares']['actions'][$methodName]) ?self::$middlewares[$className]['middlewares']['actions'][$methodName] : [];
            self::$middlewares[$className]['middlewares']['actions'][$methodName] = array_unique(array_merge($middlewares, $scanMiddlewares));
        } else {
            $scanMiddlewares = !empty(self::$middlewares[$className]['middlewares']['group']) ? self::$middlewares[$className]['middlewares']['group'] : [];
            self::$middlewares[$className]['middlewares']['group'] = array_unique(array_merge($middlewares, $scanMiddlewares));
        }
    }
}
