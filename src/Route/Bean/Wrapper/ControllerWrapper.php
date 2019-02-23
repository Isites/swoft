<?php

namespace Grace\Swoft\Route\Bean\Wrapper;

use Grace\Swoft\Bean\Annotation\Enum;
use Grace\Swoft\Bean\Annotation\Floats;
use Grace\Swoft\Bean\Annotation\Inject;
use Grace\Swoft\Bean\Annotation\Integer;
use Grace\Swoft\Route\Bean\Annotation\Middleware;
use Grace\Swoft\Route\Bean\Annotation\Middlewares;
use Grace\Swoft\Bean\Annotation\Number;
use Grace\Swoft\Bean\Annotation\Strings;
use Grace\Swoft\Bean\Annotation\Value;
use Grace\Swoft\Bean\Wrapper\AbstractWrapper;
use Grace\Swoft\Route\Bean\Annotation\Controller;
use Grace\Swoft\Route\Bean\Annotation\RequestMapping;

/**
 * 路由注解封装器
 *
 * @uses      ControllerWrapper
 * @version   2017年09月04日
 * @author    stelin <phpcrazy@126.com>
 * @copyright Copyright 2010-2016 swoft software
 * @license   PHP Version 7.x {@link http://www.php.net/license/3_0.txt}
 */
class ControllerWrapper extends AbstractWrapper
{
    /**
     * 类注解
     *
     * @var array
     */
    protected $classAnnotations = [
        Controller::class,
        Middlewares::class,
        Middleware::class,
    ];

    /**
     * 属性注解
     *
     * @var array
     */
    protected $propertyAnnotations = [
        Inject::class,
        Value::class,
    ];

    /**
     * 方法注解
     *
     * @var array
     */
    protected $methodAnnotations = [
        RequestMapping::class,
        Middlewares::class,
        Middleware::class,
        Strings::class,
        Floats::class,
        Number::class,
        Integer::class,
        Enum::class
    ];

    /**
     * 是否解析类注解
     *
     * @param array $annotations
     * @return bool
     */
    public function isParseClassAnnotations($annotations)
    {
        return isset($annotations[Controller::class]);
    }

    /**
     * 是否解析属性注解
     *
     * @param array $annotations
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
     * @return bool
     */
    public function isParseMethodAnnotations($annotations)
    {
        return true;
    }
}
