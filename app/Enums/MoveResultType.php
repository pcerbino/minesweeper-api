<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class MoveResultType extends Enum
{
    const Success =  'success';
    const Won = 'won';
    const Loose = 'loose';

}
