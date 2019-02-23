<?php

namespace Grace\Swoft\Bean\Annotation;

class Custom {
    public function forMethod() {
        return true;
    }
    public function getParserName() {
        return 'Custom';
    }
}
