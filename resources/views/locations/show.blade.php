<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                📍 {{ $location->name }}
            </h2>

            <a href="{{ route('locations.index') }}"
               class="text-sm px-3 py-1 bg-gray-700 text-gray-200 rounded hover:bg-gray-600 transition">
                ← Retour
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto px-6">
            <div class="bg-gray-900 border border-gray-800 p-6 rounded-xl shadow">

                {{-- Titre --}}
                <h3 class="text-2xl font-bold text-white mb-6">
                    {{ $location->name }}
                </h3>

                {{-- Infos --}}
                <div class="space-y-4">

                    <div class="flex justify-between items-center border-b border-gray-800 pb-2">
                        <span class="text-gray-400">Ville</span>
                        <span class="text-indigo-400 font-medium">
                            {{ $location->city }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center border-b border-gray-800 pb-2">
                        <span class="text-gray-400">Pays</span>
                        <span class="text-gray-200">
                            {{ $location->country }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center border-b border-gray-800 pb-2">
                        <span class="text-gray-400">Upvotes</span>
                        <span class="text-green-400 font-semibold">
                            👍 {{ $location->upvotes_count }}
                        </span>
                    </div>

                    <div>
                        <span class="text-gray-400 block mb-2">Description</span>
                        <p class="text-gray-200 leading-relaxed">
                            {{ $location->description ?? 'Aucune description' }}
                        </p>
                    </div>

                </div>

                {{-- Actions --}}
                @if(auth()->user()->is_admin || auth()->id() === $location->user_id)
                    <div class="mt-6 flex justify-end gap-2">

                        <a href="{{ route('locations.edit', $location) }}"
                           class="px-3 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700 text-sm">
                            Modifier
                        </a>

                        <form action="{{ route('locations.destroy', $location) }}"
                              method="POST"
                              onsubmit="return confirm('Supprimer cette localisation ?')">
                            @csrf
                            @method('DELETE')

                            <button class="px-3 py-1 bg-red-700 text-white rounded hover:bg-red-600 text-sm">
                                Supprimer
                            </button>
                        </form>

                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>