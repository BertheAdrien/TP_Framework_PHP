<x-app-layout>
   <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                ➕ Créer une localisation
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

                <form action="{{ route('locations.store') }}" method="POST">
                    @csrf

                    <div class="space-y-4">

                        {{-- Nom --}}
                        <input type="text" name="name" placeholder="Nom"
                               class="w-full p-2 rounded bg-gray-800 text-white"
                               required>

                        {{-- Ville --}}
                        <input type="text" name="city" placeholder="Ville"
                               class="w-full p-2 rounded bg-gray-800 text-white"
                               required>

                        {{-- Pays --}}
                        <input type="text" name="country" placeholder="Pays"
                               class="w-full p-2 rounded bg-gray-800 text-white"
                               required>

                        {{-- Film (select avec recherche) --}}
                        <div>
                            <label class="text-sm text-gray-400">Film</label>
                            <select name="film_id" id="film-select"
                                    class="w-full p-2 rounded bg-gray-800 text-white"
                                    required>
                                <option value="">Choisir un film</option>
                                @foreach($films as $film)
                                    <option value="{{ $film->id }}">
                                        {{ $film->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Description --}}
                        <textarea name="description" placeholder="Description"
                                  class="w-full p-2 rounded bg-gray-800 text-white"></textarea>

                        {{-- User caché --}}
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                        {{-- Actions --}}
                        <div class="flex justify-between items-center pt-4">
                            <a href="{{ route('locations.index') }}"
                               class="text-gray-400 hover:text-gray-200 text-sm">
                                ← Annuler
                            </a>

                            <button class="bg-indigo-600 px-4 py-2 rounded text-white hover:bg-indigo-700 transition">
                                Créer
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