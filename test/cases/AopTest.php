<?php
namespace test;

use Grace\Swoft\Bean\Annotation\Bean;

/**
 * @Bean("aopTest")
 */
class AopTest {

    public function test() {
        echo "test";
        return 123;
    }

}
