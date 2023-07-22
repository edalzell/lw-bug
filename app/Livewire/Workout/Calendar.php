<?php

namespace App\Livewire\Workout;

use App\Models\Workout;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;

class Calendar extends Component
{
    public Carbon $startsAt;

    public Carbon $endsAt;

    public Carbon $gridStartsAt;

    public Carbon $gridEndsAt;

    public int $weekStartsAt;

    public int $weekEndsAt;

    public string $dayView;

    public string $eventView;

    public string $dayOfWeekView;

    public string $dragAndDropClasses;

    public ?string $beforeCalendarView = null;

    public ?string $afterCalendarView = null;

    public bool $dragAndDropEnabled;

    public bool $dayClickEnabled;

    public bool $eventClickEnabled;

    protected $casts = [
        'startsAt' => 'date',
        'endsAt' => 'date',
        'gridStartsAt' => 'date',
        'gridEndsAt' => 'date',
    ];

    public function mount(
        int $initialYear = null,
        int $initialMonth = null,
        int $weekStartsAt = null,
        string $dragAndDropClasses = null,
        bool $dragAndDropEnabled = true,
        bool $dayClickEnabled = true,
        bool $eventClickEnabled = true,
        array $extras = []): void
    {
        $this->weekStartsAt = $weekStartsAt ?? Carbon::SUNDAY;
        $this->weekEndsAt = $this->weekStartsAt == Carbon::SUNDAY
            ? Carbon::SATURDAY
            : collect([0, 1, 2, 3, 4, 5, 6])->get($this->weekStartsAt + 6 - 7);

        $initialYear = $initialYear ?? Carbon::today()->year;
        $initialMonth = $initialMonth ?? Carbon::today()->month;

        $this->startsAt = Carbon::createFromDate($initialYear, $initialMonth, 1)->startOfDay();
        $this->endsAt = $this->startsAt->clone()->endOfMonth()->startOfDay();

        $this->calculateGridStartsEnds();

        $this->dayView = 'livewire.calendar.day';
        $this->eventView = 'livewire.calendar.event';
        $this->dayOfWeekView = 'livewire.calendar.day-of-week';

        $this->dragAndDropEnabled = $dragAndDropEnabled;
        $this->dragAndDropClasses = $dragAndDropClasses ?? 'border border-blue-400 border-4';

        $this->dayClickEnabled = $dayClickEnabled;
        $this->eventClickEnabled = $eventClickEnabled;

        $this->afterMount($extras);
    }

    public function afterMount($extras = []): void
    {
        //
    }

    public function goToPreviousMonth(): void
    {
        $this->startsAt->subMonthNoOverflow();
        $this->endsAt->subMonthNoOverflow();

        $this->calculateGridStartsEnds();
    }

    public function goToNextMonth(): void
    {
        $this->startsAt->addMonthNoOverflow();
        $this->endsAt->addMonthNoOverflow();

        $this->calculateGridStartsEnds();
    }

    public function goToCurrentMonth(): void
    {
        $this->startsAt = Carbon::today()->startOfMonth()->startOfDay();
        $this->endsAt = $this->startsAt->clone()->endOfMonth()->startOfDay();

        $this->calculateGridStartsEnds();
    }

    public function calculateGridStartsEnds(): void
    {
        $this->gridStartsAt = $this->startsAt->clone()->startOfWeek($this->weekStartsAt);
        $this->gridEndsAt = $this->endsAt->clone()->endOfWeek($this->weekEndsAt);
    }

    /**
     * @throws Exception
     */
    public function monthGrid(): Collection
    {
        $firstDayOfGrid = $this->gridStartsAt;
        $lastDayOfGrid = $this->gridEndsAt;

        $numbersOfWeeks = $lastDayOfGrid->diffInWeeks($firstDayOfGrid) + 1;
        $days = $lastDayOfGrid->diffInDays($firstDayOfGrid) + 1;

        if ($days % 7 != 0) {
            throw new Exception('Livewire Calendar not correctly configured. Check initial inputs.');
        }

        $monthGrid = collect();
        $currentDay = $firstDayOfGrid->clone();

        while (! $currentDay->greaterThan($lastDayOfGrid)) {
            $monthGrid->push($currentDay->clone());
            $currentDay->addDay();
        }

        $monthGrid = $monthGrid->chunk(7);
        if ($numbersOfWeeks != $monthGrid->count()) {
            throw new Exception('Livewire Calendar calculated wrong number of weeks. Sorry :(');
        }

        return $monthGrid;
    }

    /**
     * @return Collection<array<mixed>>
     */
    public function events(): Collection
    {
        return Workout::all()
            ->map(fn (Workout $workout) => [
                'id' => $workout->id,
                'title' => $workout->title,
                'description' => $workout->description,
                'date' => $workout->scheduled_at,
            ]);
    }

    public function getEventsForDay($day, Collection $events): Collection
    {
        return $events
            ->filter(function ($event) use ($day) {
                return Carbon::parse($event['date'])->isSameDay($day);
            });
    }

    public function onDayClick(int $year, int $month, int $day): void
    {
        $this->dispatch('create-workout', Carbon::createFromDate($year, $month, $day))->to('workout.show');
    }

    public function onEventClick(string $workoutId): void
    {
        $this->dispatch('edit-workout', $workoutId)->to('workout.show');
    }

    public function onEventDropped(string $workoutId, int $year, int $month, int $day): void
    {
        $workout = Workout::findOrFail($workoutId);

        $newScheduledAt = Carbon::createFromDate($year, $month, $day);

        if ($newScheduledAt->isBefore(now()->tomorrow())) {
            return;
        }

        $workout->update(['scheduled_at' => $newScheduledAt]);
    }

    /**
     * @return Factory|View
     *
     * @throws Exception
     */
    public function render()
    {
        $events = $this->events();

        return view('livewire.calendar.calendar')
            ->with([
                'componentId' => $this->getId(),
                'monthGrid' => $this->monthGrid(),
                'events' => $events,
                'getEventsForDay' => fn ($day) => $this->getEventsForDay($day, $events),
            ]);
    }
}
