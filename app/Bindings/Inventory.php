<?php

namespace App\Bindings;

enum Inventory: string
{
    case increment = 'increment';
    case reduce = 'reduce';
}
