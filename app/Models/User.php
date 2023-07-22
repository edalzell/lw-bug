<?php

namespace App\Models;

use App\Concerns\Models\HasRoles;
use App\Enums\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Cashier\Billable;
use Propaganistas\LaravelPhone\Casts\E164PhoneNumberCast;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 *  @method static \App\Models\User assignRoles(...$roles)
 *  @method static \App\Models\User members()
 */
class User extends Authenticatable implements HasMedia
{
    use Billable;
    use HasFactory;
    use HasRoles;
    use InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'mobile_phone',
        'password',
        'referred_at',
        'referrer_id',
        'trainer_id',
    ];

    /**
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'mobile_phone' => E164PhoneNumberCast::class,
        'referred_at' => 'immutable_datetime',
    ];

    public function members(): HasMany
    {
        return $this->hasMany(self::class, 'trainer_id');
    }

    /**
     * @return BelongsTo<User, User>
     */
    public function trainer(): BelongsTo
    {
        return $this->belongsTo(self::class, 'trainer_id');
    }

    /**
     * @param  Builder<User>  $query
     */
    public function scopeMembers(Builder $query): void
    {
        $query->role(Role::Member);
    }

    /**
     * @param  Builder<User>  $query
     */
    public function scopeTrainers(Builder $query): void
    {
        $query->role(Role::Trainer);
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return '';
    }
}
