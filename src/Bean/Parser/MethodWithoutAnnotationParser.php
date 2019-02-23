<?php

namespace Grace\Swoft\Bean\Parser;

use Grace\Swoft\Helper\ComponentHelper;

/**
 * 方法没有注解解析器
 *
 * @uses      MethodWithoutAnnotationParser
 * @version   2017年09月04日
 * @author    stelin <phpcrazy@126.com>
 * @copyright Copyright 2010-2016 swoft software
 * @license   PHP Version 7.x {@link http://www.php.net/license/3_0.txt}
 */
class MethodWithoutAnnotationParser extends AbstractParser
{
    /**
     * 方法没有注解解析
     *
     * @param string $className
     * @param null   $objectAnnotation
     * @param string $propertyName
     * @param string $methodName
     * @param null   $propertyValue
     *
     * @return mixed
     */
    public function parser($className, $objectAnnotation = null, $propertyName = "", $methodName = "", $propertyValue = null)
    {
        $paths = explode(DIRECTORY_SEPARATOR, dirname(__FILE__));
        $swoftDir      = implode(DIRECTORY_SEPARATOR, array_slice($paths, 0, count($paths) - 5));
        $componentDirs = scandir($swoftDir);
        foreach ($componentDirs as $component) {
            if ($component == '.' || $component == '..') {
                continue;
            }

            $componentCommandDir = $swoftDir . DS . $component . DS . 'src/Bean/Collector';
            if (!is_dir($componentCommandDir)) {
                continue;
            }

            $componentNs = ComponentHelper::getComponentNs($component);
            $collectNs = "Swoft{$componentNs}\\Bean\\Collector";
            $collectorFiles = scandir($componentCommandDir);
            foreach ($collectorFiles as $collectorFile){
                $pathInfo = pathinfo($collectorFile);
                if(!isset($pathInfo['filename'])){
                    continue;
                }
                $fileName = $pathInfo['filename'];
                $collectClassName = $collectNs.'\\'.$fileName;
                if(!class_exists($collectClassName)){
                    continue;
                }

                /* @var \Grace\Swoft\Bean\CollectorInterface $collector */
                $collector = new $collectClassName();
                $collector->collect($className, $objectAnnotation, $propertyName, $methodName, $propertyValue);
            }
        }

        return null;
    }
}
