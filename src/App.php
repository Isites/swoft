<?php

namespace Grace\Swoft;

use Grace\Swoft\Bean\BeanFactory;



class App {
    public static function getBean($name)
    {
        return BeanFactory::getBean($name);
    }

    public static function hasBean($name) {
        return BeanFactory::hasBean($name);
    }
}
