<?php

namespace App\Data;

use Illuminate\Support\Collection;
use Livewire\Wireable;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Sometimes;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class Station extends Data implements Wireable
{
    use WireableData;

    protected static string $_collectionClass = StationCollection::class;

    public function __construct(
        #[Required, IntegerType]
        public ?int $sets = null,

        #[Sometimes, Required, StringType]
        public ?string $title = null,

        #[Required, DataCollectionOf(Exercise::class)]
        public ?DataCollection $exercises = null
    ) {
    }

    public function exerciseCollection(): Collection
    {
        if (is_null($this->exercises)) {
            return collect([]);
        }

        return $this->exercises
            ->toCollection()
            ->mapWithKeys(fn (Exercise $exercise) => [$exercise->id => $exercise->activity])
            ->collect();
    }
}
