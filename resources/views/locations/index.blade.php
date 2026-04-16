<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            🎬 Gestion des Localisations
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 shadow-sm sm:rounded-lg p-6">

                {{-- Header --}}
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        Liste des localisations
                        <span class="ml-2 text-sm font-normal text-gray-400">
                            ({{ $locations->count() }})
                        </span>
                    </h3>

                    <a href="{{ route('locations.create') }}"
                       class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-lg hover:bg-indigo-700 transition font-medium">
                        + Ajouter une localisation
                    </a>
                </div>

                {{-- Alerts --}}
                @if(session('success'))
                    <div class="mb-4 p-3 bg-green-900/40 border border-green-700 text-green-300 rounded-lg text-sm">
                        ✓ {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 p-3 bg-red-900/40 border border-red-700 text-red-300 rounded-lg text-sm">
                        ✗ {{ session('error') }}
                    </div>
                @endif

                {{-- Table --}}
                @if($locations->count() > 0)
                    <div class="overflow-x-auto rounded-lg border border-gray-700">
                        <table class="min-w-full table-fixed divide-y divide-gray-700 text-sm">

                            <thead class="bg-gray-800 text-gray-400 uppercase text-xs tracking-wider">
                                <tr>
                                    <th class="px-4 py-3 text-left w-12">#</th>
                                    <th class="px-4 py-3 text-left w-40">Nom</th>
                                    <th class="px-4 py-3 text-left w-32">Ville</th>
                                    <th class="px-4 py-3 text-left w-48">Pays</th>
                                    <th class="px-4 py-3 text-left">Description</th>
                                    <th class="px-4 py-3 text-center w-24">Upvotes</th>
                                    <th class="px-4 py-3 text-right w-40">Actions</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-800 bg-gray-900">
                                @foreach($locations as $location)
                                    <tr class="hover:bg-gray-800/60 transition">

                                        {{-- ID --}}
                                        <td class="px-4 py-3 text-gray-500 tabular-nums">
                                            {{ $location->id }}
                                        </td>

                                        {{-- Nom --}}
                                        <td class="px-4 py-3 font-medium text-gray-100 truncate">
                                            {{ $location->name }}
                                        </td>

                                        {{-- Ville --}}
                                        <td class="px-4 py-3 text-indigo-400 truncate">
                                            {{ $location->city }}
                                        </td>

                                        {{-- Pays --}}
                                        <td class="px-4 py-3 text-gray-400">
                                            <span id="short-{{ $location->id }}">
                                                {{ \Illuminate\Support\Str::limit($location->country, 60) }}
                                            </span>

                                            <span id="full-{{ $location->id }}" class="hidden">
                                                {{ $location->country }}
                                            </span>

                                            @if(strlen($location->country) > 60)
                                                <button onclick="toggleSynopsis({{ $location->id }})"
                                                        id="btn-{{ $location->id }}"
                                                        class="text-indigo-400 hover:text-indigo-300 text-xs ml-1 underline">
                                                    Voir plus
                                                </button>
                                            @endif
                                        </td>

                                        {{-- Description --}}
                                        <td class="px-4 py-3 text-gray-300">
                                            <div class="truncate max-w-md">
                                                {{ $location->description }}
                                            </div>
                                        </td>

                                        {{-- Upvotes --}}
                                        <td class="px-4 py-3 text-center text-gray-300 tabular-nums">
                                            {{ $location->upvotes_count }}
                                        </td>

                                        {{-- Actions --}}
                                        <td class="px-4 py-3 text-right">
                                            <div class="inline-flex gap-1 justify-end">

                                                <a href="{{ route('locations.show', $location) }}"
                                                   class="px-2 py-1 bg-gray-700 text-gray-200 rounded text-xs hover:bg-gray-600 transition">
                                                    Voir
                                                </a>

                                                <a href="{{ route('locations.edit', $location) }}"
                                                   class="px-2 py-1 bg-indigo-700 text-indigo-100 rounded text-xs hover:bg-indigo-600 transition">
                                                    Éditer
                                                </a>

                                                <form action="{{ route('locations.destroy', $location) }}"
                                                      method="POST"
                                                      class="inline"
                                                      onsubmit="return confirm('Supprimer « {{ addslashes($location->name) }} » ?')">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button class="px-2 py-1 bg-red-800 text-red-200 rounded text-xs hover:bg-red-700 transition">
                                                        Suppr.
                                                    </button>
                                                </form>

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <p class="mt-3 text-xs text-gray-500">
                        Total : {{ $locations->count() }} location(s)
                    </p>

                @else
                    <div class="text-center py-16 text-gray-500">
                        <p class="text-4xl mb-4">🎬</p>
                        <p class="mb-4">Aucune location pour l'instant.</p>

                        <a href="{{ route('locations.create') }}"
                           class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-sm">
                            Ajouter la première location
                        </a>
                    </div>
                @endif

            </div>
        </div>
    </div>

    <script>
        function toggleSynopsis(id) {
            const short = document.getElementById('short-' + id);
            const full  = document.getElementById('full-' + id);
            const btn   = document.getElementById('btn-' + id);

            const expanded = full.classList.toggle('hidden');
            short.classList.toggle('hidden');

            btn.textContent = expanded ? 'Voir plus' : 'Voir moins';
        }
    </script>

</x-app-layout>