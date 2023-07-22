<?php

namespace App\Livewire\Workout;

use App\Data\Station;
use App\Data\StationCollection;
use App\Enums\WorkoutType;
use App\Models\Workout;
use Carbon\CarbonImmutable;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rules\Enum;
use Livewire\Attributes\On;
use Livewire\Component;

class Show extends Component
{
    public ?string $description = null;

    public ?string $notes = null;

    public ?CarbonImmutable $scheduledAt = null;

    public bool $show = false;

    public ?StationCollection $stations = null;

    public ?int $timeCap = null;

    public ?string $title = null;

    public ?string $type = null;

    public ?int $workoutId = null;

    public function addStation(): void
    {
        if (is_null($this->stations)) {
            $this->stations = StationCollection::make([]);
        }

        $this->stations->addStation(new Station());
    }

    public function deleteStation(int $index): void
    {
        $this->stations?->deleteStation($index);
    }

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function render()
    {
        return view('livewire.workout.show');
    }

    /**
     * @return array<string, array<int, \Illuminate\Validation\Rules\Enum|string>>
     */
    public function rules(): array
    {
        return array_merge(
            [
                'description' => ['sometimes', 'string'],
                'notes' => ['sometimes', 'string'],
                'scheduledAt' => ['required', 'date', 'after_or_equal:tomorrow'],
                'stations' => ['required', 'array'],
                'time_cap' => ['sometimes', 'integer'],
                'title' => ['required', 'min:3'],
                'type' => ['required', new Enum(WorkoutType::class)],
            ],
            Arr::prependKeysWith(
                array: Station::getValidationRules([]),
                prependWith: 'stations.*.'
            )
        );
    }

    public function save(): void
    {
        $this->validate();

        Workout::updateOrCreate(
            [
                'scheduled_at' => $this->scheduledAt,
            ],
            [
                'title' => $this->title,
                'description' => $this->description,
                'time_cap' => $this->timeCap,
                'type' => $this->type,
                'stations' => $this->stations,
                'notes' => $this->notes,
            ]
        );

        $this->show = false;
    }

    #[On('edit-workout')]
    public function load(Workout $workout): void
    {
        $this->description = $workout->description;
        $this->timeCap = $workout->time_cap;
        $this->type = $workout->type->value;
        $this->scheduledAt = $workout->scheduled_at;
        $this->stations = $workout->stations;
        $this->title = $workout->title;
        $this->workoutId = $workout->id;

        $this->show = true;
    }

    #[On('create-workout')]
    public function new(Carbon $scheduledAt): void
    {
        $this->reset();

        $this->scheduledAt = $scheduledAt->startOfDay()->toImmutable();

        $this->show = true;
    }
}
