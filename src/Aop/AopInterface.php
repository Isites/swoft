<?php

namespace Grace\Swoft\Aop;

/**
 * the interface of aop
 *
 * @uses      AopInterface
 * @version   2017年12月24日
 * @copyright Copyright 2010-2016 swoft software
 * @license   PHP Version 7.x {@link http://www.php.net/license/3_0.txt}
 */
interface AopInterface
{
    /**
     * execute by aop
     *
     * @param object $target
     * @param string $method
     * @param array  $params
     *
     * @return mixed
     */
    public function execute($target, $method, $params);

    /**
     * register aop
     *
     * @param array $aspects
     */
    public function register($aspects);
}
