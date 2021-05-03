<?php
namespace Modules\Shifts\Facade;

use Illuminate\Support\Facades\Facade;
class Shift  extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "shift";
    }
}