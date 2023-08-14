<?php

namespace Nahidferdous\Conversation\Facades;

use Illuminate\Support\Facades\Facade;

class Conversation extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'Conversation';
    }
}
