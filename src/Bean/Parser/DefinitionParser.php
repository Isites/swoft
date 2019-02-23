<?php

namespace Grace\Swoft\Bean\Parser;

use Grace\Swoft\Bean\Annotation\Definition;
use Grace\Swoft\Bean\Annotation\Scope;
use Grace\Swoft\Bean\Collector\DefinitionCollector;

/**
 * The parser of definition
 */
class DefinitionParser extends AbstractParser
{
    /**
     * @param string     $className
     * @param Definition $objectAnnotation
     * @param string     $propertyName
     * @param string     $methodName
     * @param mixed      $propertyValue
     *
     * @return array
     */
    public function parser(string $className, $objectAnnotation = null, string $propertyName = "", string $methodName = "", $propertyValue = null)
    {
        $beanName = $objectAnnotation->getName();
        $beanName = empty($beanName) ? $className : $beanName;
        $scope    = Scope::SINGLETON;

        DefinitionCollector::collect($className, $objectAnnotation, $propertyName, $methodName, $propertyValue);

        return [$beanName, $scope, ""];
    }
}
