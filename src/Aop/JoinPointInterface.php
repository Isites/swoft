<?php

namespace Grace\Swoft\Aop;

/**
 * the join point of interface
 *
 * @uses      JoinPointInterface
 * @version   2017年12月25日
 * @copyright Copyright 2010-2016 swoft software
 * @license   PHP Version 7.x {@link http://www.php.net/license/3_0.txt}
 */
interface JoinPointInterface
{
    /**
     * @return array
     */
    public function getArgs();

    /**
     * @return object
     */
    public function getTarget();

    /**
     * @return string
     */
    public function getMethod();
}
