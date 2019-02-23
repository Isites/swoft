<?php

namespace Grace\Swoft\Bean\Wrapper;

use Grace\Swoft\Bean\Wrapper\Extend\WrapperExtendInterface;

/**
 * Annotation Wrapper Interface
 */
interface WrapperInterface
{
    /**
     * 封装注解
     *
     * @param string $className
     * @param array  $annotations
     * @return array|null
     */
    public function doWrapper($className, $annotations);

    /**
     * 是否解析类注解
     *
     * @param array $annotations
     * @return bool
     */
    public function isParseClassAnnotations($annotations);

    /**
     * 是否解析属性注解
     *
     * @param array $annotations
     * @return bool
     */
    public function isParsePropertyAnnotations($annotations);

    /**
     * 是否解析方法注解
     *
     * @param array $annotations
     * @return bool
     */
    public function isParseMethodAnnotations($annotations);

    /**
     * @param WrapperExtendInterface $extend
     */
    public function addExtends($extend);
}
