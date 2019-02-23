<?php

namespace Grace\Swoft\Bean;

use Grace\Swoft\Aop\Aop;
use Grace\Swoft\Bean\Collector\BootBeanCollector;
use Grace\Swoft\Bean\Collector\DefinitionCollector;
use Grace\Swoft\Core\Config;
use Grace\Swoft\Helper\ArrayHelper;
use Grace\Swoft\Helper\DirHelper;

/**
 * Bean Factory
 */
class BeanFactory implements BeanFactoryInterface
{
    /**
     * @var Container Bean container
     */
    private static $container;

    /**
     * Init beans
     * @throws \InvalidArgumentException
     * @throws \ReflectionException
     */
    public static function init($options = array())
    {
        $properties = [
            'bootScan' => [
                "ares\\",
                'Grace\Swoft\Aop',
            ]
        ];
        $properties = array_merge($properties, $options);

        self::$container = new Container();
        self::$container->setProperties($properties);
        self::$container->autoloadServerAnnotation();

        // $definition = self::getServerDefinition();
        // self::$container->addDefinitions($definition);
        self::$container->initBeans();
    }

    /**
     * Get bean from container
     *
     * @param string $name Bean name
     *
     * @return mixed
     */
    public static function getBean($name)
    {
        return self::$container->get($name);
    }

    /**
     * Determine if bean exist in container
     *
     * @param string $name Bean name
     *
     * @return bool
     */
    public static function hasBean($name)
    {
        return self::$container->hasBean($name);
    }

    /**
     * @return array
     * @throws \InvalidArgumentException
     */
    private static function getServerDefinition()
    {
        return [];
        // $file             = App::getAlias('@console');
        $configDefinition = [];

        if (\is_readable($file)) {
            $configDefinition = require_once $file;
        }

        $coreBeans  = self::getCoreBean(BootBeanCollector::TYPE_SERVER);

        return ArrayHelper::merge($coreBeans, $configDefinition);
    }

    /**
     * @param string $type
     *
     * @return array
     */
    private static function getCoreBean($type)
    {
        $collector = BootBeanCollector::getCollector();
        if (!isset($collector[$type])) {
            return [];
        }

        $coreBeans = [];
        /** @var array $bootBeans */
        $bootBeans = $collector[$type];
        foreach ($bootBeans as $beanName) {
            /* @var \Grace\Swoft\Core\BootBeanInterface $bootBean */
            $bootBean  = App::getBean($beanName);
            $beans     = $bootBean->beans();
            $coreBeans = ArrayHelper::merge($coreBeans, $beans);
        }

        return $coreBeans;
    }

    /**
     * @return array
     */
    private static function getComponentDefinitions()
    {
        $definitions = [];
        $collector   = DefinitionCollector::getCollector();

        foreach ($collector as $className => $beanName) {
            /* @var \Grace\Swoft\Bean\DefinitionInterface $definition */
            $definition = App::getBean($beanName);

            $definitions = ArrayHelper::merge($definitions, $definition->getDefinitions());
        }

        return $definitions;
    }

    /**
     * @return Container
     */
    public static function getContainer()
    {
        return self::$container;
    }
}
