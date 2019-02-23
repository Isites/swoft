<?php

namespace Grace\Swoft\Route\Bean\Parser;

use Grace\Swoft\Bean\Parser\AbstractParser;
use Grace\Swoft\Route\Bean\Annotation\Middlewares;
use Grace\Swoft\Route\Bean\Collector\MiddlewareCollector;

/**
 * Middlewares parser
 */
class MiddlewaresParser extends AbstractParser
{

    /**
     * Parse middlewares annotation
     *
     * @param string      $className
     * @param Middlewares $objectAnnotation
     * @param string      $propertyName
     * @param string      $methodName
     * @param string|null $propertyValue
     *
     * @return mixed
     */
    public function parser(
        $className,
        $objectAnnotation = null,
        $propertyName = '',
        $methodName = '',
        $propertyValue = null
    ) {
        MiddlewareCollector::collect($className, $objectAnnotation, $propertyName, $methodName, $propertyValue);
        return null;
    }
}
