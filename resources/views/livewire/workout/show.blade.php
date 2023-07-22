<x-modal.dialog wire:model="show">
    <form wire:submit="save">
        <x-slot name="title">Edit Workout</x-slot>
        <x-slot name="content">
            <x-input.group for="title" label="Title" :error="$errors->first('workout.title')">
                <x-input.text wire:model="title" id="workout-title" title="Title" type="text" />
            </x-input.group>

            <x-input.group for="description" label="Description" :error="$errors->first('description')">
                <div class="flex rounded-md shadow-sm">
                    <textarea
                        wire:model="description"
                        id="description"
                        rows="3"
                        class="block w-full transition duration-150 ease-in-out form-textarea sm:text-sm sm:leading-5"></textarea>
                </div>
            </x-input.group>

            <x-input.group for="type" label="Type" :error="$errors->first('type')">
                <x-input.select wire:model="type" id="type">
                    @foreach (App\Enums\WorkoutType::select() as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </x-input.select>
            </x-input.group>

            <x-input.group for="scheduled_at" label="Date" :error="$errors->first('scheduledAt')">
                <x-input.date wire:model="scheduledAt" id="scheduled_at"/>
            </x-input.group>
            @if ($stations)
                <h3>Stations</h3>
                @foreach ($stations as $station)
                    <x-input.group for="stations" label="Stations">
                        <x-input.text wire:model="stations.{{ $loop->index }}.sets" id="sets-{{ $loop->index }}" title="Sets" type="number" />
                        <x-input.text wire:model="stations.{{ $loop->index }}.title" id="title-{{ $loop->index }}" title="Title"/>
                        <x-button.primary wire:click="deleteStation({{ $loop->index }})">Delete</x-button.primary>
                    </x-input.group>
                    <x-button.primary wire:click="deleteStation({{ $loop->index }})">Delete
                    </x-button.primary>
                @endforeach
            @endif

        </x-slot>

        <x-slot name="footer">
            <x-button.secondary wire:click="addStation">Add Station</x-button.secondary>
            <x-button.secondary wire:click="$set('show', false)">Cancel</x-button.secondary>

            @if ($scheduledAt > \Carbon\Carbon::today())
                <x-button.primary type="submit">Save</x-button.primary>
            @endif
        </x-slot>
    </form>
</x-model.dialog>
