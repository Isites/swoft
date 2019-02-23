<?php

namespace Grace\Swoft\Bean\Parser;

use Grace\Swoft\Bean\Annotation\Handler;
use Grace\Swoft\Bean\Annotation\Scope;
use Grace\Swoft\Bean\Collector\ExceptionHandlerCollector;

/**
 * the parser of handler
 *
 * @uses      HandlerParser
 * @version   2018年01月17日
 * @author    stelin <phpcrazy@126.com>
 * @copyright Copyright 2010-2016 swoft software
 * @license   PHP Version 7.x {@link http://www.php.net/license/3_0.txt}
 */
class HandlerParser extends AbstractParser
{
    /**
     * Listen注解解析
     *
     * @param string  $className
     * @param Handler $objectAnnotation
     * @param string  $propertyName
     * @param string  $methodName
     *
     * @return array
     */
    public function parser($className, $objectAnnotation = null, $propertyName = "", $methodName = "", $propertyValue = null)
    {
        $beanName = $className;
        $scope    = Scope::SINGLETON;
        ExceptionHandlerCollector::collect($className, $objectAnnotation, $propertyName, $methodName, $propertyValue);

        return [$beanName, $scope, ""];
    }
}
