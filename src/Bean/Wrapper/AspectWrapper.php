<?php

namespace Grace\Swoft\Bean\Wrapper;

use Grace\Swoft\Bean\Annotation\After;
use Grace\Swoft\Bean\Annotation\AfterReturning;
use Grace\Swoft\Bean\Annotation\AfterThrowing;
use Grace\Swoft\Bean\Annotation\Around;
use Grace\Swoft\Bean\Annotation\Aspect;
use Grace\Swoft\Bean\Annotation\Before;
use Grace\Swoft\Bean\Annotation\Inject;
use Grace\Swoft\Bean\Annotation\PointAnnotation;
use Grace\Swoft\Bean\Annotation\PointBean;
use Grace\Swoft\Bean\Annotation\PointExecution;

/**
 * the aspect of wrapper
 *
 * @uses      AspectWrapper
 * @version   2017年12月24日
 * @author    stelin <phpcrazy@126.com>
 * @copyright Copyright 2010-2016 swoft software
 * @license   PHP Version 7.x {@link http://www.php.net/license/3_0.txt}
 */
class AspectWrapper extends AbstractWrapper
{
    /**
     * 类注解
     *
     * @var array
     */
    protected $classAnnotations = [
        Aspect::class,
        PointBean::class,
        PointAnnotation::class,
        PointExecution::class,
    ];

    /**
     * 属性注解
     *
     * @var array
     */
    protected $propertyAnnotations = [
        Inject::class,
    ];

    /**
     * 方法注解
     *
     * @var array
     */
    protected $methodAnnotations = [
        Before::class,
        After::class,
        AfterReturning::class,
        AfterThrowing::class,
        Around::class,
    ];

    /**
     * 是否解析类注解
     *
     * @param array $annotations
     * @return bool
     */
    public function isParseClassAnnotations($annotations)
    {
        return isset($annotations[Aspect::class]);
    }

    /**
     * 是否解析属性注解
     *
     * @param array $annotations
     * @return bool
     */
    public function isParsePropertyAnnotations($annotations)
    {
        return isset($annotations[Inject::class]);
    }

    /**
     * 是否解析方法注解
     *
     * @param array $annotations
     * @return bool
     */
    public function isParseMethodAnnotations($annotations)
    {
        $after = isset($annotations[After::class]) || isset($annotations[AfterThrowing::class]) || isset($annotations[AfterReturning::class]);

        return isset($annotations[Before::class]) || isset($annotations[Around::class]) || $after;
    }
}
