<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                📝 Modifier une localisation
            </h2>

            {{-- Bouton retour --}}
            <a href="{{ route('locations.index') }}"
               class="text-sm px-3 py-1 bg-gray-700 text-gray-200 rounded hover:bg-gray-600 transition">
                ← Retour
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto px-6">
            <div class="bg-white dark:bg-gray-900 p-6 rounded-lg shadow">

                <form action="{{ route('locations.update', $location) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-4">

                        {{-- Nom --}}
                        <input type="text" name="name"
                               value="{{ old('name', $location->name) }}"
                               placeholder="Nom"
                               class="w-full p-2 rounded bg-gray-800 text-white"
                               required>

                        {{-- Ville --}}
                        <input type="text" name="city"
                               value="{{ old('city', $location->city) }}"
                               placeholder="Ville"
                               class="w-full p-2 rounded bg-gray-800 text-white"
                               required>

                        {{-- Pays --}}
                        <input type="text" name="country"
                               value="{{ old('country', $location->country) }}"
                               placeholder="Pays"
                               class="w-full p-2 rounded bg-gray-800 text-white"
                               required>

                        {{-- Film --}}
                        <div>
                            <label class="text-sm text-gray-400">Film</label>
                            <select name="film_id" id="film-select"
                                    class="w-full p-2 rounded bg-gray-800 text-white"
                                    required>
                                @foreach($films as $film)
                                    <option value="{{ $film->id }}"
                                        {{ old('film_id', $location->film_id) == $film->id ? 'selected' : '' }}>
                                        {{ $film->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Description --}}
                        <textarea name="description"
                                  placeholder="Description"
                                  class="w-full p-2 rounded bg-gray-800 text-white">{{ old('description', $location->description) }}</textarea>

                        {{-- Actions --}}
                        <div class="flex justify-between items-center pt-4">
                            <a href="{{ route('locations.index') }}"
                               class="text-gray-400 hover:text-gray-200 text-sm">
                                ← Annuler
                            </a>

                            <button class="bg-indigo-600 px-4 py-2 rounded text-white hover:bg-indigo-700 transition">
                                Modifier
                            </button>
                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- Tom Select --}}
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>

    <script>
        new TomSelect("#film-select", {
            create: false,
            sortField: {
                field: "text",
                direction: "asc"
            }
        });
    </script>

</x-app-layout>