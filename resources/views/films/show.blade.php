<x-app-layout>
        <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
               🎬{{ $film->title }}
            </h2>

            <a href="{{ route('films.index') }}"
               class="text-sm px-3 py-1 bg-gray-700 text-gray-200 rounded hover:bg-gray-600 transition">
                ← Retour
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto px-6">
            <div class="bg-gray-900 p-6 rounded-xl shadow border border-gray-800">

                <h3 class="text-2xl text-white mb-4">
                    {{ $film->title }}
                </h3>

                <p class="text-gray-400 mb-2">
                    Année : <span class="text-indigo-400">{{ $film->release_year }}</span>
                </p>

                <p class="text-gray-200">
                    {{ $film->synopsis ?? 'Aucun synopsis' }}
                </p>

                @if(auth()->user()->is_admin)
                    <div class="mt-6 flex gap-2 justify-end">
                        <a href="{{ route('films.edit', $film) }}"
                           class="px-3 py-1 bg-indigo-600 text-white rounded">
                            Modifier
                        </a>

                        <form method="POST" action="{{ route('films.destroy', $film) }}">
                            @csrf
                            @method('DELETE')

                            <button class="px-3 py-1 bg-red-700 text-white rounded">
                                Supprimer
                            </button>
                        </form>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>