<?php

namespace Grace\Swoft\Route\Bean\Parser;

use Grace\Swoft\Bean\Parser\AbstractParser;
use Grace\Swoft\Route\Bean\Annotation\RequestMapping;
use Grace\Swoft\Route\Bean\Collector\ControllerCollector;

/**
 * RequestMapping注解解析器
 *
 * @uses      RequestMappingParser
 * @version   2017年09月03日
 * @author    stelin <phpcrazy@126.com>
 * @copyright Copyright 2010-2016 swoft software
 * @license   PHP Version 7.x {@link http://www.php.net/license/3_0.txt}
 */
class RequestMappingParser extends AbstractParser
{

    /**
     * RequestMapping注解解析
     *
     * @param string $className
     * @param RequestMapping $objectAnnotation
     * @param string $propertyName
     * @param string $methodName
     * @param null|mixed $propertyValue
     */
    public function parser(
        $className,
        $objectAnnotation = null,
        $propertyName = '',
        $methodName = '',
        $propertyValue = null
    ) {
        $collector = ControllerCollector::getCollector();

        if (!isset($collector[$className])) {
            return;
        }

        // Collect requestMapping
        ControllerCollector::collect($className, $objectAnnotation, $propertyName, $methodName, $propertyValue);
    }
}
