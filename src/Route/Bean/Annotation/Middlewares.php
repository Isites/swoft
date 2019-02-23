<?php

namespace Grace\Swoft\Route\Bean\Annotation;

use Doctrine\Common\Annotations\Annotation\Target;

/**
 * Middlewares annotation
 *
 * @Annotation
 * @Target({"ALL"})
 */
class Middlewares
{

    /**
     * @var array
     */
    private $middlewares = [];

    /**
     * @var string
     */
    private $group = '';

    /**
     * Middlewares constructor.
     *
     * @param array $values
     */
    public function __construct($values)
    {
        if (isset($values['value'])) {
            $this->middlewares = $values['value'];
        }
        if (isset($values['middlewares'])) {
            $this->middlewares = $values['value'];
        }
        if (isset($values['group'])) {
            $this->group = $values['value'];
        }
    }

    /**
     * @return array
     */
    public function getMiddlewares()
    {
        return $this->middlewares;
    }

    /**
     * @param array $middlewares
     * @return Middlewares
     */
    public function setMiddlewares($middlewares)
    {
        $this->middlewares = $middlewares;
        return $this;
    }

    /**
     * @return string
     */
    public function getGroup()
    {
        return $this->group;
    }
}
