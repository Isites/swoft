##简介

一个轻量级的**注解路由**和面**向切面编程**的框架。没有多余的reqeust和复杂的底层封装， 专注于注解路由和面向切面编程， 所以本框架在开启缓存后， 自身运行时间很短。目前认为本框架特别适合做一些web应用和api的开发， 对于一些有自己的缓存框架， 本框架也可以作为其应用层使用。

> 注： 本框架是基于swoft中的代码进行修改， 仅仅保留了注解路由和面向切面编程的功能， 如果需要使用swoole或者数据库链接池等功能， 请[去这儿](https://github.com/swoft-cloud/swoft)

## 安装

1. composer 配置

```json
"repositories": [
    {
        "type": "vcs",
        "url": "git@github.com:Isites/swoft.git"
    }
]
```

2. 步骤**1**执行完后, 请执`composer istall`

## 使用

#### AOP使用

```php
//先定义一个切面类， 表示需要插入的点， 注解很重要， 不要忽略
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

/**
 * @Bean("aopTest")
 */
class AopTest {

    public function test() {
        echo "test";
        return 123;
    }

}

//执行
$bean = BeanFactory::getBean("aopTest");
print_r($bean->test());
```

> 上面example的输出结果如下：
>
> string(9) " before1 "
>
> teststring(8) " after1 "
>
> 123 around-before1  around-after1  afterReturn1

#### 注解路由的使用

```php
/**
 * @Controller(prefix="/common")
 */
class TestController {

    /**
     * @RequestMapping("nav")
     */
    public function nav() {
        echo "12312";
    }
}

$handlerAdaptor = BeanFactory::getBean("httpHandlerAdapter");
$response = $handlerAdaptor->doHandler($httpHandler);
print_r($reponse);
//输出结果： 12312
```

#### 补充说明

1. 注解路由支持方法的限定， 即某一方法可以先定为post或者get请求
2. 注解路由支持正则表达式的匹配
3. aop支持对方法级别的切面， 使用注解为`PointAnnotation`



#### 希望大家多多交流～

联系: 23shuaixw@gmail.com

