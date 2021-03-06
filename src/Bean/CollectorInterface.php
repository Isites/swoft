<?php

namespace Grace\Swoft\Bean;

/**
 * Annotaions Data Collector Interface
 */
interface CollectorInterface
{
    /**
     * @param string $className
     * @param object|null $objectAnnotation
     * @param string $propertyName
     * @param string $methodName
     * @param null $propertyValue
     * @return mixed
     */
    public static function collect(
        $className,
        $objectAnnotation = null,
        $propertyName = '',
        $methodName = '',
        $propertyValue = null
    );

    /**
     * @param array $data
     * @return boolean
     */
    public static function init($data);

    /**
     * @return mixed
     */
    public static function getCollector();
}
