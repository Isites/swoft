<?php

namespace Grace\Swoft\Bean;

/**
 * Bean factory interface
 */
interface BeanFactoryInterface
{
    /**
     * Get bean
     *
     * @param string $name
     * @return mixed
     */
    public static function getBean($name);

    /**
     * @param string $name
     * @return bool
     */
    public static function hasBean($name);
}
