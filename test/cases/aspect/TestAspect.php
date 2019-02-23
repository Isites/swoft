<?php

namespace test\aspect;


use Grace\Swoft\Bean\Annotation\Aspect;
use Grace\Swoft\Bean\Annotation\PointBean;
use Grace\Swoft\Bean\Annotation\Before;
use Grace\Swoft\Bean\Annotation\After;
use Grace\Swoft\Bean\Annotation\AfterReturning;
use Grace\Swoft\Bean\Annotation\Around;
use Grace\Swoft\Bean\Annotation\AfterThrowing;

// use ares\AspectTest\AopTest;


/**
 * @Aspect()
 * @PointBean(
 *  include={"aopTest"}
 * )
 */
class TestAspect {
    private $test = "";
     /**
     * @Before()
     */
    public function before()
    {
        var_dump(' before1 ');
    }

    /**
     * @After()
     */
    public function after()
    {
        var_dump(' after1 ');
    }

    /**
     * @AfterReturning()
     */
    public function afterReturn($joinPoint)
    {
        $result = $joinPoint->getReturn();
        return $result.' afterReturn1 ';
    }

    /**
     * @Around()
     * @param ProceedingJoinPoint $proceedingJoinPoint
     * @return mixed
     */
    public function around($proceedingJoinPoint)
    {
        $this->test .= ' around-before1 ';
        $result = $proceedingJoinPoint->proceed();
        $this->test .= ' around-after1 ';
        return $result.$this->test;
    }

}
