<?php

namespace Grace\Swoft\Aop;

use Grace\Swoft\App;

/**
 * the proceedingJoinPoint of class
 *
 * @uses      ProceedingJoinPoint
 * @copyright Copyright 2010-2016 swoft software
 * @license   PHP Version 7.x {@link http://www.php.net/license/3_0.txt}
 */
class ProceedingJoinPoint extends JoinPoint implements ProceedingJoinPointInterface
{
    /**
     * @var array
     */
    private $advice;

    /**
     * @var array
     */
    private $advices;

    /**
     * ProceedingJoinPoint constructor.
     *
     * @param object $target
     * @param string $method
     * @param array  $args
     * @param array  $advice
     * @param array  $advices
     */
    public function __construct($target, $method, $args, $advice, $advices)
    {
        parent::__construct($target, $method, $args, null);
        $this->advice  = $advice;
        $this->advices = $advices;
    }

    /**
     * proceed
     *
     * @param array $params
     * If the params is not empty, the params is used to call the method of target
     *
     * @return mixed
     */
    public function proceed($params = [])
    {
        // before
        if (isset($this->advice['before']) && !empty($this->advice['before'])) {
            list($aspectClass, $aspectMethod) = $this->advice['before'];
            $aspect = App::getBean($aspectClass);
            $aspect->$aspectMethod();
        }

        if (empty($this->advices)) {
            // execute
            $methodParams = !empty($params) ? $params : $this->args;
            $result       = call_user_func_array(array($this->target, $this->method), $methodParams);
            // $result       = $this->target->{$this->method}(...$methodParams);
        } else {
            /* @var \Grace\Swoft\Aop\Aop $aop */
            $aop    = App::getBean(Aop::class);
            $result = $aop->doAdvice($this->target, $this->method, $this->args, $this->advices);
        }

        return $result;
    }

    public function reProceed($args = [])
    {
    }
}
