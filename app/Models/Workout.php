<?php

namespace App\Models;

use App\Data\Station;
use App\Data\StationCollection;
use App\Enums\WorkoutType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Spatie\LaravelData\DataCollection;

/**
 * @property StationCollection<Station::class> $stations
 */
class Workout extends Model
{
    use HasFactory;

    protected $casts = [
        'scheduled_at' => 'immutable_date:Y-m-d',
        'stations' => StationCollection::class.':'.Station::class,
        'type' => WorkoutType::class,
    ];

    protected $guarded = [
        'id',
    ];

    public static function today(): self
    {
        return static::whereDate('scheduled_at', Carbon::today())->sole();
    }

    public function allExercises(): Collection
    {
        return $this->stations
            ->map(fn (Station $station) => $station->exerciseCollection())
            ->toCollection()
            ->collapse()
            ->collect();
    }

    /**
     * @return DataCollection<Exercise::class>
     */
    public function stationExercises(int $station): DataCollection
    {
        return $this->stations[$station]->exercises;
    }

    public function addStation(Station $station): self
    {
        $this->stations[] = $station;

        return $this;
    }

    public function deleteStation(int $index): self
    {
        $this->stations->deleteStation($index);

        return $this;
    }
}
