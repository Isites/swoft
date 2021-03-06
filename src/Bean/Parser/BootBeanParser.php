<?php

namespace Grace\Swoft\Bean\Parser;

use Grace\Swoft\Bean\Annotation\BootBean;
use Grace\Swoft\Bean\Annotation\Scope;
use Grace\Swoft\Bean\Collector\BootBeanCollector;

/**
 * The parser of boot bean
 */
class BootBeanParser extends AbstractParser
{
    /**
     * @param string   $className
     * @param BootBean $objectAnnotation
     * @param string   $propertyName
     * @param string   $methodName
     * @param mixed    $propertyValue
     *
     * @return array
     */
    public function parser(string $className, $objectAnnotation = null, string $propertyName = "", string $methodName = "", $propertyValue = null)
    {
        $beanName = $className;
        $scope    = Scope::SINGLETON;

        BootBeanCollector::collect($className, $objectAnnotation, $propertyName, $methodName, $propertyValue);

        return [$beanName, $scope, ""];
    }
}
