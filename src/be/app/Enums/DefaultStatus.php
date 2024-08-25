<?php

namespace app\Enums;

use App\Attributes\Description;
use App\Traits\AttributableEnum;

enum DefaultStatus: string
{
    use AttributableEnum;

    #[Description('Deleted')]
    case DELETED = 'deleted';
    #[Description('Activated')]
    case ACTIVATED = 'activated';

    public static function values(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }
}
