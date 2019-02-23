<?php

namespace Grace\Swoft\Route\Bean\Collector;

use Grace\Swoft\Bean\CollectorInterface;
use Grace\Swoft\Route\Bean\Annotation\Controller;
use Grace\Swoft\Route\Bean\Annotation\RequestMapping;
use Grace\Swoft\Route\Bean\Annotation\RequestMethod;

/**
 * the collector of controller
 *
 * @uses      ControllerCollector
 */
class ControllerCollector implements CollectorInterface
{
    /**
     * @var array
     */
    private static $requestMapping = [];

    /**
     * @param string $className
     * @param object $objectAnnotation
     * @param string $propertyName
     * @param string $methodName
     * @param null   $propertyValue
     */
    public static function collect(
        $className,
        $objectAnnotation = null,
        $propertyName = '',
        $methodName = '',
        $propertyValue = null
    ) {
        if ($objectAnnotation instanceof Controller) {
            $prefix = $objectAnnotation->getPrefix();
            self::$requestMapping[$className]['prefix'] = $prefix;
            return;
        }

        if ($objectAnnotation instanceof RequestMapping) {
            $route = $objectAnnotation->getRoute();
            $httpMethod = $objectAnnotation->getMethod();
            self::$requestMapping[$className]['routes'][] = [
                'route'  => $route,
                'method' => $httpMethod,
                'action' => $methodName,
                'params' => $objectAnnotation->getParams(),
            ];
            return;
        }

        if ($objectAnnotation === null && isset(self::$requestMapping[$className])) {
            self::$requestMapping[$className]['routes'][] = [
                'route'  => '',
                'method' => [RequestMethod::GET, RequestMethod::POST],
                'action' => $methodName,
            ];
            return;
        }
    }

    /**
     * @return array
     */
    public static function getCollector()
    {
        return self::$requestMapping;
    }

}
