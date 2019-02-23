<?php

namespace Grace\Swoft\Bean\Parser;

use Grace\Swoft\Bean\Annotation\AfterThrowing;
use Grace\Swoft\Bean\Collector\AspectCollector;

/**
 * the before advice of parser
 *
 * @uses      AfterThrowingParser
 * @version   2017年12月24日
 * @author    stelin <phpcrazy@126.com>
 * @copyright Copyright 2010-2016 swoft software
 * @license   PHP Version 7.x {@link http://www.php.net/license/3_0.txt}
 */
class AfterThrowingParser extends AbstractParser
{
    /**
     * afterThrowing parsing
     *
     * @param string        $className
     * @param AfterThrowing $objectAnnotation
     * @param string        $propertyName
     * @param string        $methodName
     * @param null          $propertyValue
     *
     * @return mixed
     */
    public function parser($className, $objectAnnotation = null, $propertyName = "", $methodName = "", $propertyValue = null)
    {
        AspectCollector::collect($className, $objectAnnotation, $propertyName, $methodName, $propertyValue);

        return null;
    }
}
