<?php

namespace app\Enums;

use App\Attributes\Description;
use App\Traits\AttributableEnum;

enum UserStatus: string
{
    use AttributableEnum;
    #[Description('Active')]
    case ACTIVE='active';
    #[Description('Hold')]
    case HOLD='hold';
    #[Description('Disable')]
    case DISABLE='disable';
    #[Description('Removed')]
    case REMOVED='removed';


    public static function values(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }
}
