<?php

namespace Grace\Swoft\Bean\Parser;

use Grace\Swoft\Bean\Annotation\Scope;
use Grace\Swoft\Bean\Annotation\ServerListener;
use Grace\Swoft\Bean\Collector\ServerListenerCollector;

/**
 * Class ServerListenerParser
 * @package Grace\Swoft\Bean\Parser
 * @author inhere <in.798@qq.com>
 */
class ServerListenerParser extends AbstractParser
{
    /**
     * @param string      $className
     * @param ServerListener $objectAnnotation
     * @param string      $propertyName
     * @param string      $methodName
     * @param mixed       $propertyValue
     *
     * @return array
     */
    public function parser(string $className, $objectAnnotation = null, string $propertyName = '', string $methodName = '', $propertyValue = null)
    {
        $beanName = $className;
        $scope    = Scope::SINGLETON;

        ServerListenerCollector::collect($className, $objectAnnotation, $propertyName, $methodName, $propertyValue);

        return [$beanName, $scope, ''];
    }
}
