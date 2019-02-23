<?php
/**
 * @version   2017-11-02
 * @author    huangzhhui <huangzhwork@gmail.com>
 * @copyright Copyright 2010-2017 Swoft software
 * @license   PHP Version 7.x {@link http://www.php.net/license/3_0.txt}
 */


if (! function_exists('value')) {
    /**
     * Return the callback value
     *
     * @param mixed $value
     * @return mixed
     */
    function value($value)
    {
        return $value instanceof \Closure ? $value() : $value;
    }
}

if (! function_exists('env')) {
    /**
     * Gets the value of an environment variable.
     *
     * @param  string $key
     * @param  mixed  $default
     * @return mixed
     */
    function env($key, $default = null)
    {
        $value = getenv($key);

        if ($value === false) {
            return value($default);
        }

        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;
            case 'false':
            case '(false)':
                return false;
            case 'empty':
            case '(empty)':
                return '';
            case 'null':
            case '(null)':
                return;
        }

        if (strlen($value) > 1 && \Grace\Swoft\Helper\StringHelper::startsWith($value, '"') && \Grace\Swoft\Helper\StringHelper::endsWith($value, '"')) {
            return substr($value, 1, -1);
        }

        if (defined($value)) {
            $value = constant($value);
        }

        return $value;
    }
}

if (! function_exists('cache')) {

    /**
     * Get the cache by $key value, return $default when cache not exist
     *
     * @param string|null $key
     * @param mixed       $default
     * @return \Psr\SimpleCache\CacheInterface|string
     */
    function cache($key = null, $default = null)
    {
        /* @var Grace\Swoft\Cache\Cache $cache */
        $cache = \Grace\Swoft\App::getBean('cache');

        if ($key === null) {
            return $cache->getDriver();
        }

        return $cache->get($key, value($default));
    }
}

if (! function_exists('bean')) {
    /**
     * Get bean from container
     *
     * @param string $name
     * @return object
     */
    function bean($name)
    {
        return \Grace\Swoft\App::getBean($name);
    }
}

if (! function_exists('config')) {
    /**
     * Get config value from app config
     *
     * @param string $key
     * @param null|mixed $default
     * @return mixed
     */
    function config($key, $default = null)
    {
        /** @see \Grace\Swoft\Core\Config::get() */
        return \Grace\Swoft\App::getBean('config')->get($key, $default);
    }
}

if (! function_exists('alias')) {
    /**
     * Get alias
     *
     * @param string $alias
     * @return string
     * @throws \InvalidArgumentException
     */
    function alias($alias)
    {
        return \Grace\Swoft\App::getAlias($alias);
    }
}

if (!function_exists('is_iterable')) {
    /**
     * is_iterable
     * @param $obj
     * @return bool
     */
    function is_iterable($obj)
    {
        return is_array($obj) || (is_object($obj) && ($obj instanceof \Traversable));
    }
}
