<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                📝 Modifier un film
            </h2>

            {{-- Bouton retour --}}
            <a href="{{ route('films.index') }}"
                class="text-sm px-3 py-1 bg-gray-700 text-gray-200 rounded hover:bg-gray-600 transition">
                ← Retour
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto px-6">
            <div class="bg-gray-900 p-6 rounded-lg shadow">

                <form action="{{ route('films.update', $film) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-4">

                        <input type="text" name="title" value="{{ old('title', $film->title) }}"
                            class="w-full p-2 rounded bg-gray-800 text-white" required>

                        <input type="number" name="release_year" value="{{ old('release_year', $film->release_year) }}"
                            class="w-full p-2 rounded bg-gray-800 text-white" required>

                        <textarea name="synopsis" class="w-full p-2 rounded bg-gray-800 text-white">{{ old('synopsis', $film->synopsis) }}</textarea>

                        <div class="flex justify-between">
                            <a href="{{ route('films.index') }}" class="text-gray-400">← Retour</a>

                            <button class="bg-indigo-600 px-4 py-2 rounded text-white">
                                Modifier
                            </button>
                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
