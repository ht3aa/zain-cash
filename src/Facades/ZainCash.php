<?php

namespace Ht3aa\ZainCash\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Ht3aa\ZainCash\ZainCash
 */
class ZainCash extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Ht3aa\ZainCash\ZainCash::class;
    }
}
