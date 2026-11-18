<?php

namespace App\Enums\V1;

use App\Attributes\Description;
use App\Traits\AttributableEnum;

enum TaskStatus: string
{
    use AttributableEnum;

    #[Description('Todo')]
    case TODO = 'todo';
    #[Description('In-progress')]
    case IN_PROGRESS = 'in_progress';
    #[Description('Done')]
    case DONE = 'done';

    public static function values(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }
}
