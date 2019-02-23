<?php
/**
 * This file is part of Swoft.
 *
 * @link     https://swoft.org
 * @document https://doc.swoft.org
 * @contact  group@swoft.org
 * @license  https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace Grace\Swoft\Aop;

use Grace\Swoft\Bean\Annotation\Bean;
use Grace\Swoft\Bean\Collector\AspectCollector;
use \Throwable;

/**
 * @Bean()
 */
class Aop implements AopInterface
{
    /**
     * @var array
     */
    private $map = [];

    /**
     * @var array
     */
    private $aspects = [];

    /**
     * @return void
     */
    public function init()
    {
        // Register aspects by aspect annotation collector
        $collector = AspectCollector::getCollector();
        $this->register($collector);
    }

    /**
     * Execute origin method by aop
     *
     * @param object $target Origin object
     * @param string $method The execution method
     * @param array $params The parameters of execution method
     * @return mixed
     * @throws \ReflectionException
     * @throws Throwable
     */
    public function execute($target, $method, $params)
    {
        $class = \get_class($target);

        // If doesn't have any advices, then execute the origin method
        if (!isset($this->map[$class][$method]) || empty($this->map[$class][$method])) {
            return call_user_func_array(array($target, $method), $params);
            // return $target->$method(...$params);
        }

        // Apply advices's functionality
        $advices = $this->map[$class][$method];
        return $this->doAdvice($target, $method, $params, $advices);
    }

    /**
     * @param object $target  Origin object
     * @param string $method  The execution method
     * @param array  $params  The parameters of execution method
     * @param array  $advices The advices of this object method
     * @return mixed
     * @throws \ReflectionException|Throwable
     */
    public function doAdvice($target, $method, $params, $advices)
    {
        $result = null;
        $advice = \array_shift($advices);

        try {

            // Around
            if (isset($advice['around']) && ! empty($advice['around'])) {
                $result = $this->doPoint($advice['around'], $target, $method, $params, $advice, $advices);
            } else {
                // Before
                if (isset($advice['before']) && ! empty($advice['before'])) {
                    // The result of before point will not effect origin object method
                    $this->doPoint($advice['before'], $target, $method, $params, $advice, $advices);
                }
                if (0 === \count($advices)) {
                    $result = call_user_func_array(array($target, $method), $params);
                    // $result = $target->$method(...$params);
                } else {
                    $this->doAdvice($target, $method, $params, $advices);
                }
            }

            // After
            if (isset($advice['after']) && ! empty($advice['after'])) {
                $this->doPoint($advice['after'], $target, $method, $params, $advice, $advices, $result);
            }
        } catch (Throwable $t) {
            if (isset($advice['afterThrowing']) && ! empty($advice['afterThrowing'])) {
                return $this->doPoint($advice['afterThrowing'], $target, $method, $params, $advice, $advices, null, $t);
            }

            throw $t;
        }

        // afterReturning
        if (isset($advice['afterReturning']) && ! empty($advice['afterReturning'])) {
            return $this->doPoint($advice['afterReturning'], $target, $method, $params, $advice, $advices, $result);
        }

        return $result;
    }

    /**
     * Do pointcut
     *
     * @param array  $pointAdvice the pointcut advice
     * @param object $target      Origin object
     * @param string $method      The execution method
     * @param array  $args        The parameters of execution method
     * @param array  $advice      the advice of pointcut
     * @param array  $advices     The advices of this object method
     * @param mixed  $return
     * @param Throwable $catch    The  Throwable object caught
     * @return mixed
     * @throws \ReflectionException
     */
    private function doPoint(
        $pointAdvice,
        $target,
        $method,
        $args,
        $advice,
        $advices,
        $return = null,
        $catch = null
    ) {
        list($aspectClass, $aspectMethod) = $pointAdvice;

        $reflectionClass = new \ReflectionClass($aspectClass);
        $reflectionMethod = $reflectionClass->getMethod($aspectMethod);
        $reflectionParameters = $reflectionMethod->getParameters();

        // Bind the param of method
        $aspectArgs = [];
        foreach ($reflectionParameters as $reflectionParameter) {
            $parameterType = method_exists($reflectionParameter, "getType") ? $reflectionParameter->getType() : $reflectionParameter->getName();
            if(empty($parameterType)) {
                $parameterType = $reflectionParameter->getName();
            }
            //可以根据参数名字取得类型
            if ($parameterType === null) {
                $aspectArgs[] = null;
                continue;
            }

            // JoinPoint object
            $type = strtolower($parameterType);
            $classNameArr = explode("\\", strtolower(JoinPoint::class));
            $className = end($classNameArr);
            if ($type === $className) {
                $aspectArgs[] = new JoinPoint($target, $method, $args, $return, $catch);
                continue;
            }

            // ProceedingJoinPoint object
            $classNameArr = explode("\\", strtolower(ProceedingJoinPoint::class));
            $className = end($classNameArr);
            if ($type === $className) {
                $aspectArgs[] = new ProceedingJoinPoint($target, $method, $args, $advice, $advices);
                continue;
            }

            // Throwable object
            if ($catch) {
                $aspectArgs[] = $catch;
                continue;
            }
            $aspectArgs[] = null;
        }

        $aspect = \bean($aspectClass);

        return call_user_func_array(array($aspect, $aspectMethod), $aspectArgs);
        // return $aspect->$aspectMethod(...$aspectArgs);
    }

    /**
     * Match aop
     *
     * @param string $beanName    Bean name
     * @param string $class       Class name
     * @param string $method      Method name
     * @param array  $annotations The annotations of method
     */
    public function match($beanName, $class, $method, $annotations)
    {
        foreach ($this->aspects as $aspectClass => $aspect) {
            if (!isset($aspect['point'], $aspect['advice'])) {
                continue;
            }

            // Include
            $pointBeanInclude = !empty($aspect['point']['bean']['include']) ? $aspect['point']['bean']['include'] : [];
            $pointAnnotationInclude = !empty($aspect['point']['annotation']['include']) ? $aspect['point']['annotation']['include'] : [];
            $pointExecutionInclude = !empty($aspect['point']['execution']['include']) ? $aspect['point']['execution']['include'] : [];

            // Exclude
            $pointBeanExclude = !empty($aspect['point']['bean']['exclude']) ? $aspect['point']['bean']['exclude'] : [];
            $pointAnnotationExclude = !empty($aspect['point']['annotation']['exclude']) ? $aspect['point']['annotation']['exclude'] : [];
            $pointExecutionExclude = !empty($aspect['point']['execution']['exclude']) ? $aspect['point']['execution']['exclude'] : [];

            $includeMath = $this->matchBeanAndAnnotation([$beanName], $pointBeanInclude) || $this->matchBeanAndAnnotation($annotations, $pointAnnotationInclude) || $this->matchExecution($class, $method, $pointExecutionInclude);

            $excludeMath = $this->matchBeanAndAnnotation([$beanName], $pointBeanExclude) || $this->matchBeanAndAnnotation($annotations, $pointAnnotationExclude) || $this->matchExecution($class, $method, $pointExecutionExclude);

            if ($includeMath && ! $excludeMath) {
                $this->map[$class][$method][] = $aspect['advice'];
            }
        }
    }

    /**
     * Register aspects
     *
     * @param array $aspects
     */
    public function register($aspects)
    {
        $temp = \array_column($aspects, 'order');
        \array_multisort($temp, SORT_ASC, $aspects);
        $this->aspects = $aspects;
    }

    /**
     * Match bean and annotation
     *
     * @param array $pointAry
     * @param array $classAry
     * @return bool
     */
    private function matchBeanAndAnnotation($pointAry, $classAry)
    {
        $intersectAry = \array_intersect($pointAry, $classAry);
        if (empty($intersectAry)) {
            return false;
        }

        return true;
    }

    /**
     * Match execution
     *
     * @param string $class
     * @param string $method
     * @param array  $executions
     * @return bool
     */
    private function matchExecution($class, $method, $executions)
    {
        foreach ($executions as $execution) {
            $executionAry = \explode('::', $execution);
            if (\count($executionAry) < 2) {
                continue;
            }

            // Class
            list($executionClass, $executionMethod) = $executionAry;
            if ($executionClass !== $class) {
                continue;
            }

            // Method
            $reg = '/^(?:' . $executionMethod . ')$/';
            if (\preg_match($reg, $method)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return array
     */
    public function getAspects()
    {
        return $this->aspects;
    }

    /**
     * @return array
     */
    public function getMap()
    {
        return $this->map;
    }
}
