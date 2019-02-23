<?php

namespace Grace\Swoft\Bean\Parser;

/**
 * Annotation Parser Interface
 */
interface ParserInterface
{
    /**
     * 解析注解
     *
     * @param string      $className
     * @param object      $objectAnnotation
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
    );
}
