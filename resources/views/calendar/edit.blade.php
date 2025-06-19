<x-nav>
    <h1 class="text-6xl font-bold">Edit Event</h1>
{{--    <div class="container mx-auto flex justify-center items-center min-h-screen w-full">--}}
{{--        <div class="bg-white dark:bg-accentBlue p-8 rounded shadow-lg w-full max-w-md">--}}
            <form method="POST" action="{{ route('calendar.update', $event->id) }}">
                @csrf
                @method('PUT')
                <label for="event" class="block mt-2 text-sm font-medium text-viridian dark:text-greenLight mb-2">Name</label>
                <input
                    type="text"
                    id="event"
                    name="event"
                    value="{{ old('event', $event->event) }}"
                    required
                    class="w-full px-4 py-2 border rounded border-gray-300 dark:border-gray-600 bg-greenLight text-viridian dark:bg-articleBlue dark:text-viridian focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
                <label for="date" class="block mt-2 text-sm font-medium text-viridian dark:text-greenLight mb-2">Date & Time</label>
                <input
                    type="datetime-local"
                    id="date"
                    name="date"
                    value="{{ old('date', \Carbon\Carbon::parse($event->date)->format('Y-m-d\TH:i')) }}"
                    required
                    class="w-full px-4 py-2 border rounded border-gray-300 dark:border-gray-600 bg-greenLight text-viridian dark:bg-articleBlue dark:text-viridian focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
                <div class="flex justify-end gap-2 mt-6">
                    <a href="{{ route('calendar.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded">Cancel</a>
                    <button type="submit" class="bg-accentBlue text-white px-4 py-2 rounded">Update</button>
                </div>
            </form>
{{--        </div>--}}
{{--    </div>--}}
</x-nav>

{{--test--}}
