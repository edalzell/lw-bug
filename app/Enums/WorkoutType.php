<?php

namespace App\Enums;

use Illuminate\Support\Collection;

enum WorkoutType: string
{
    case AMRAP = 'amrap';
    case FIXED = 'fixed';
    case TIME = 'time';
    case MAX = 'max';

    /**
     * @return \Illuminate\Support\Collection<string, string>
     */
    public static function select(): Collection
    {
        return collect(WorkoutType::cases())
             ->flatMap(fn (WorkoutType $type) => [$type->value => $type->label()]);
    }

    public function label(): string
    {
        return match ($this) {
            self::AMRAP => 'AMRAP',
            self::FIXED => 'Fixed',
            self::TIME => 'Time',
            self::MAX => 'Max',
        };
    }
}
