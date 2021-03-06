<?php

namespace Grace\Swoft\Bean\Collector;

use Grace\Swoft\Bean\Annotation\After;
use Grace\Swoft\Bean\Annotation\AfterReturning;
use Grace\Swoft\Bean\Annotation\AfterThrowing;
use Grace\Swoft\Bean\Annotation\Around;
use Grace\Swoft\Bean\Annotation\Aspect;
use Grace\Swoft\Bean\Annotation\Before;
use Grace\Swoft\Bean\Annotation\PointAnnotation;
use Grace\Swoft\Bean\Annotation\PointBean;
use Grace\Swoft\Bean\Annotation\PointExecution;
use Grace\Swoft\Bean\CollectorInterface;

/**
 * the collector of aspect
 *
 * @uses      AspectCollector
 * @version   2018年01月14日
 * @author    stelin <phpcrazy@126.com>
 * @copyright Copyright 2010-2016 swoft software
 * @license   PHP Version 7.x {@link http://www.php.net/license/3_0.txt}
 */
class AspectCollector implements CollectorInterface
{
    const KEY = 'Aspect_Collector';
    /**
     * @var array
     */
    private static $aspects = [];

    /**
     * @param string $className
     * @param object $objectAnnotation
     * @param string $propertyName
     * @param string $methodName
     * @param null   $propertyValue
     */
    public static function collect($className, $objectAnnotation = null, $propertyName = '', $methodName = '', $propertyValue = null)
    {
        if ($objectAnnotation instanceof AfterReturning) {
            self::collectAfterReturning($className, $methodName);
        } elseif ($objectAnnotation instanceof AfterThrowing) {
            self::collectAfterThrowing($className, $methodName);
        } elseif ($objectAnnotation instanceof Around) {
            self::collectAround($className, $methodName);
        } elseif ($objectAnnotation instanceof Before) {
            self::collectBefore($className, $methodName);
        } elseif ($objectAnnotation instanceof After) {
            self::collectAfter($className, $methodName);
        } elseif ($objectAnnotation instanceof Aspect) {
            self::collectAspect($objectAnnotation, $className);
        } elseif ($objectAnnotation instanceof PointAnnotation) {
            self::collectPointAnnotation($objectAnnotation, $className);
        } elseif ($objectAnnotation instanceof PointBean) {
            self::collectPointBean($objectAnnotation, $className);
        } elseif ($objectAnnotation instanceof PointExecution) {
            self::collectPointExecution($objectAnnotation, $className);
        }
    }

    /**
     * @param PointExecution $objectAnnotation
     * @param string         $className
     *
     * @return void
     */
    private static function collectPointExecution($objectAnnotation, $className)
    {
        if (!isset(self::$aspects[$className])) {
            return null;
        }

        $include = $objectAnnotation->getInclude();
        $exclude = $objectAnnotation->getExclude();

        self::$aspects[$className]['point']['execution'] = [
            'include' => $include,
            'exclude' => $exclude,
        ];
    }

    /**
     * @param PointBean $objectAnnotation
     * @param string    $className
     *
     * @return void
     */
    private static function collectPointBean($objectAnnotation, $className)
    {
        if (!isset(self::$aspects[$className])) {
            return null;
        }

        $include = $objectAnnotation->getInclude();
        $exclude = $objectAnnotation->getExclude();

        self::$aspects[$className]['point']['bean'] = [
            'include' => $include,
            'exclude' => $exclude,
        ];
    }

    /**
     * @param PointAnnotation $objectAnnotation
     * @param string          $className
     *
     * @return void
     */
    private static function collectPointAnnotation($objectAnnotation, $className)
    {
        if (!isset(self::$aspects[$className])) {
            return null;
        }

        $include = $objectAnnotation->getInclude();
        $exclude = $objectAnnotation->getExclude();

        self::$aspects[$className]['point']['annotation'] = [
            'include' => $include,
            'exclude' => $exclude,
        ];
    }

    /**
     * @param Aspect $objectAnnotation
     * @param string $className
     */
    private static function collectAspect($objectAnnotation, $className)
    {
        $order = $objectAnnotation->getOrder();

        self::$aspects[$className]['order'] = $order;
    }

    /**
     * @param string $className
     * @param string $methodName
     *
     * @return void
     */
    private static function collectAfter($className, $methodName)
    {
        if (!isset(self::$aspects[$className])) {
            return null;
        }

        self::$aspects[$className]['advice']['after'] = [$className, $methodName];
    }

    /**
     * @param string $className
     * @param string $methodName
     *
     * @return void
     */
    private static function collectBefore($className, $methodName)
    {
        if (!isset(self::$aspects[$className])) {
            return null;
        }

        self::$aspects[$className]['advice']['before'] = [$className, $methodName];
    }

    /**
     * @param string $className
     * @param string $methodName
     *
     * @return void
     */
    private static function collectAround($className, $methodName)
    {
        if (!isset(self::$aspects[$className])) {
            return null;
        }

        self::$aspects[$className]['advice']['around'] = [$className, $methodName];
    }

    /**
     * @param string $className
     * @param string $methodName
     *
     * @return void
     */
    private static function collectAfterThrowing($className, $methodName)
    {
        if (!isset(self::$aspects[$className])) {
            return null;
        }

        self::$aspects[$className]['advice']['afterThrowing'] = [$className, $methodName];
    }

    /**
     * @param string $className
     * @param string $methodName
     *
     * @return void
     */
    private static function collectAfterReturning($className, $methodName)
    {
        if (!isset(self::$aspects[$className])) {
            return null;
        }
        self::$aspects[$className]['advice']['afterReturning'] = [$className, $methodName];
    }

    /**
     * @param array $data
     * @return boolean
     */
    public static function init($data) {
        if(is_array($data) && isset($data[self::KEY])) {
            self::$aspects = $data[self::KEY];
            return true;
        }
        return false;
    }

    /**
     * @return array
     */
    public static function getCollector()
    {
        return self::$aspects;
    }
}
