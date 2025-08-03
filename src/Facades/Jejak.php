<?php

namespace Dewakoding\Jejak\Facades;

use Illuminate\Support\Facades\Facade;

class Jejak extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'jejak';
    }
}