<?php

namespace Grace\Swoft\Helper;

/**
 * php帮助类
 * @package Grace\Swoft\Helper
 * @author inhere <in.798@qq.com>
 */
class PhpHelper
{
    /**
     * is Cli
     *
     * @return  boolean
     */
    public static function isCli()
    {
        return PHP_SAPI === 'cli';
    }

    /**
     * 是否是mac环境
     *
     * @return bool
     */
    public static function isMac()
    {
        return \stripos(PHP_OS, 'Darwin') !== false;
    }

    /**
     * 调用
     *
     * @param mixed $cb   callback函数，多种格式
     * @param array $args 参数
     *
     * @return mixed
     */
    public static function call($cb, $args = [])
    {
        $ret = null;
        if(\is_array($cb)) {
            list($obj, $mhd) = $cb;
            $ret = call_user_func_array(array($obj, $mhd), $args);
        } else {
            $ret = call_user_func_array($cb, $args);
        }
        // if (\is_object($cb) || (\is_string($cb) && \function_exists($cb))) {
        //     $ret = $cb(...$args);
        // } elseif (\is_array($cb)) {
        //     list($obj, $mhd) = $cb;
        //     $ret = \is_object($obj) ? $obj->$mhd(...$args) : $obj::$mhd(...$args);
        // } else {
        //     $ret = call_user_func_array($cb, $args);
        // }
        return $ret;
    }
}
