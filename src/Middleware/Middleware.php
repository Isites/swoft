<?php

namespace Grace\Swoft\Middleware;
use Grace\Swoft\Middleware\IMiddleware;
abstract class Middleware implements IMiddleware {
    protected $next;

    public function setNext($next) {
        $this->next = $next;
    }
}