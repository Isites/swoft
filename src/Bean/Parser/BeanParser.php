<?php

namespace Grace\Swoft\Bean\Parser;

use Grace\Swoft\Bean\Annotation\Bean;

use Grace\Swoft\Bean\Collector;
/**
 * Bean注解解析器
 *
 * @uses      BeanParser
 * @version   2017年09月03日
 * @author    stelin <phpcrazy@126.com>
 * @copyright Copyright 2010-2016 swoft software
 * @license   PHP Version 7.x {@link http://www.php.net/license/3_0.txt}
 */
class BeanParser extends AbstractParser
{
    /**
     * Bean注解解析
     *
     * @param string $className
     * @param Bean $objectAnnotation
     * @param string $propertyName
     * @param string $methodName
     * @param null $propertyValue
     * @return array
     */
    public function parser($className, $objectAnnotation = null, $propertyName = "", $methodName = "", $propertyValue = null)
    {
        $name     = $objectAnnotation->getName();
        $scope    = $objectAnnotation->getScope();
        $ref      = $objectAnnotation->getRef();
        $beanName = empty($name) ? $className : $name;

        return [$beanName, $scope, $ref];
    }
}
