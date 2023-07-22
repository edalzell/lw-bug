<?php

namespace App\Models;

use App\Enums\Role as RoleEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends \Spatie\Permission\Models\Role
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $guarded = [
        'id',
    ];

    /**
     * @return Attribute<callable, never>
     */
    protected function type(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => RoleEnum::from($value),
        );
    }
}
