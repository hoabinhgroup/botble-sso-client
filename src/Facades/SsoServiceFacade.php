<?php

namespace Botble\SsoLogin\Facades;

use Botble\SsoLogin\Supports\SsoService;
use Illuminate\Support\Facades\Facade;

class SsoServiceFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return SsoService::class;
    }
}
