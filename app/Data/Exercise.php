<?php

namespace App\Data;

use Illuminate\Support\Collection;
use Livewire\Wireable;
use Ramsey\Uuid\Uuid;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;

class Exercise extends Data implements Wireable
{
    use WireableData;

    public function __construct(
        #[Required, StringType]
        public string $id,

        #[Required, StringType]
        public string $activity,

        #[StringType]
        public ?string $video = null
    ) {
    }

    public static function prepareForPipeline(Collection $properties): Collection
    {
        if (! $properties->get('id')) {
            $properties->put('id', Uuid::uuid4()->toString());
        }

        return $properties;
    }
}
