<?php

namespace Grace\Swoft\Bean;

use Grace\Swoft\Bean\CollectorInterface;
use Grace\Swoft\Bean\Annotation\Custom;

/**
 * Annotaions data collector
 */
class Collector implements CollectorInterface
{
    const KEY = 'Annotation_Collector';
    /**
     * The annotations of method
     *
     * @var array
     */
    public static $methodAnnotations = [];

    public static function collect(
        $className,
        $objectAnnotation = null,
        $propertyName = '',
        $methodName = '',
        $propertyValue = null
    ) {
        if(!isset(self::$methodAnnotations[$className][$methodName])) {
            self::$methodAnnotations[$className][$methodName] = array();
        }
        self::$methodAnnotations[$className][$methodName][] = get_class($objectAnnotation);
    }

    /**
     * @param array $data
     * @return boolean
     */
    public static function init($data) {
        if(is_array($data) && isset($data[self::KEY])) {
            self::$methodAnnotations = $data[self::KEY];
            return true;
        }
        return false;
    }

    /**
     * @return array
     */
    public static function getCollector()
    {
        return self::$methodAnnotations;
    }
}
