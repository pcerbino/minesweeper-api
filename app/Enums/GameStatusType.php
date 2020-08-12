<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class GameStatusType extends Enum
{
    const New =  'new';
    const InProgress =  'in_progress';
    const Winned = 'winned';
    const Loosed = 'loosed';
}
