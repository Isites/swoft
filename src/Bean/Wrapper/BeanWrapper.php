<?php

namespace Grace\Swoft\Bean\Wrapper;
use Grace\Swoft\Bean\Annotation\Bean;
use Grace\Swoft\Bean\Annotation\Cacheable;
use Grace\Swoft\Bean\Annotation\CachePut;
use Grace\Swoft\Bean\Annotation\Inject;
use Grace\Swoft\Bean\Annotation\Value;

/**
 * Bean封装器
 *
 * @uses      BeanWrapper
 * @version   2017年09月05日
 * @author    stelin <phpcrazy@126.com>
 * @copyright Copyright 2010-2016 swoft software
 * @license   PHP Version 7.x {@link http://www.php.net/license/3_0.txt}
 */
class BeanWrapper extends AbstractWrapper
{
    /**
     * 类注解
     *
     * @var array
     */
    protected $classAnnotations
        = [
            Bean::class
        ];

    /**
     * 属性注解
     *
     * @var array
     */
    protected $propertyAnnotations
        = [
            Inject::class,
            Value::class,
        ];

    /**
     * the annotations of method
     *
     * @var array
     */
    protected $methodAnnotations = [
        Cacheable::class,
        CachePut::class,
    ];

    /**
     * 是否解析类注解
     *
     * @param array $annotations
     *
     * @return bool
     */
    public function isParseClassAnnotations($annotations)
    {
        return isset($annotations[Bean::class]);
    }

    /**
     * 是否解析属性注解
     *
     * @param array $annotations
     *
     * @return bool
     */
    public function isParsePropertyAnnotations($annotations)
    {
        return isset($annotations[Inject::class]) || isset($annotations[Value::class]);
    }

    /**
     * 是否解析方法注解
     *
     * @param array $annotations
     *
     * @return bool
     */
    public function isParseMethodAnnotations($annotations)
    {
        return true;
    }

    protected function inMethodAnnotations($methodAnnotation)
    {
        return true;
    }
}
