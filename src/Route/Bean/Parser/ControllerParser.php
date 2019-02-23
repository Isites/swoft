<?php

namespace Grace\Swoft\Route\Bean\Parser;

use Grace\Swoft\Bean\Parser\AbstractParser;
use Grace\Swoft\Route\Bean\Annotation\Controller;
use Grace\Swoft\Bean\Annotation\Scope;
use Grace\Swoft\Route\Bean\Collector\ControllerCollector;

/**
 * Controller parser
 */
class ControllerParser extends AbstractParser
{
    /**
     * Parse @Controller annotation
     *
     * @param string      $className
     * @param Controller  $objectAnnotation
     * @param string      $propertyName
     * @param string      $methodName
     * @param string|null $propertyValue
     *
     * @return array
     */
    public function parser($className, $objectAnnotation = null, $propertyName = '', $methodName = '', $propertyValue = null)
    {
        $beanName = $className;
        $scope = Scope::SINGLETON;

        // collect controller
        ControllerCollector::collect($className, $objectAnnotation, $propertyName, $methodName, $propertyValue);

        return [$beanName, $scope, ''];
    }
}
