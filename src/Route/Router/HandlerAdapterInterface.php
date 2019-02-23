<?php

namespace Grace\Swoft\Route\Router;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Handler adapter interface
 */
interface HandlerAdapterInterface
{
    /**
     * execute handler
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param array                                    $handler
     *
     * @return ResponseInterface|mixed
     */
    public function doHandler($handler);
}
