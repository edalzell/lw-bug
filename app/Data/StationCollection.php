<?php

namespace App\Data;

use Illuminate\Support\Enumerable;
use Livewire\Wireable;
use Spatie\LaravelData\DataCollection;

class StationCollection extends DataCollection implements Wireable
{
    /**
     * @param  Enumerable|array<string, mixed>|DataCollection<Station>  $items
     */
    public static function make(
        Enumerable|array|DataCollection $items
    ): self {
        return new StationCollection(Station::class, $items);
    }

    public function addStation(Station $station): self
    {
        $this[] = $station;

        return $this;
    }

    public function deleteStation(int $index): self
    {
        $this->items = $this->items->collect()->forget($index)->values();

        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    public function toLivewire()
    {
        return $this->items->toArray();
    }

    /**
     * @param  array<string, mixed>  $station
     * @return self
     */
    public static function fromLivewire($station)
    {
        return static::make($station);
    }
}
