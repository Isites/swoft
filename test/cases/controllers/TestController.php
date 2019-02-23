<?php

namespace test\controllers;

use Grace\Swoft\Route\Bean\Annotation\Controller;
use Grace\Swoft\Route\Bean\Annotation\RequestMapping;


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





