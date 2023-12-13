<div>
	<div class="mb-5 flex justify-between">
		<input class="rounded" type="date" wire:model="selectedDate" wire:change="changeDate">

		<div>
			{{ \Carbon\Carbon::parse($startOfWeek)->format("d/m/Y") }}
			-
			{{ \Carbon\Carbon::parse($endOfWeek)->format("d/m/Y") }}
		</div>
	</div>

	<div class="flex rounded p-4">
		@foreach ($dates as $date)
			<div class="w-1/7">
				@livewire("daily-planner", ["date" => $date], key($date))
			</div>
		@endforeach
	</div>
</div>
