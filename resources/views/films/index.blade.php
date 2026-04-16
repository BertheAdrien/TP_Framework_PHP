<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            🎬 Gestion des Films
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 shadow-sm sm:rounded-lg p-6">

                {{-- Header --}}
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        Liste des films
                        <span class="ml-2 text-sm font-normal text-gray-400">({{ $films->count() }})</span>
                    </h3>
                    <a href="{{ route('films.create') }}"
                       class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-lg hover:bg-indigo-700 transition font-medium">
                        + Ajouter un film
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
                @if($films->count() > 0)
                    <div class="overflow-x-auto rounded-lg border border-gray-700">
                        <table class="min-w-full divide-y divide-gray-700 text-sm">

                            <thead class="bg-gray-800 text-gray-400 uppercase text-xs tracking-wider">
                                <tr>
                                    <th class="px-4 py-3 text-left w-12">#</th>
                                    <th class="px-4 py-3 text-left">Titre</th>
                                    <th class="px-4 py-3 text-left w-20">Année</th>
                                    <th class="px-4 py-3 text-left">Synopsis</th>
                                    <th class="px-4 py-3 text-right w-40">Actions</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-800 bg-gray-900">
                                @foreach($films as $film)
                                    <tr class="hover:bg-gray-800/60 transition">
                                        <td class="px-4 py-3 text-gray-500 tabular-nums">{{ $film->id }}</td>

                                        <td class="px-4 py-3 font-medium text-gray-100">
                                            {{ $film->title }}
                                        </td>

                                        <td class="px-4 py-3 text-indigo-400 tabular-nums">
                                            {{ $film->release_year }}
                                        </td>

                                        <td class="px-4 py-3 text-gray-400 max-w-xs">
                                            <span id="short-{{ $film->id }}">
                                                {{ \Illuminate\Support\Str::limit($film->synopsis, 80) }}
                                            </span>
                                            <span id="full-{{ $film->id }}" class="hidden">
                                                {{ $film->synopsis }}
                                            </span>
                                            @if(strlen($film->synopsis) > 80)
                                                <button onclick="toggleSynopsis({{ $film->id }})"
                                                        id="btn-{{ $film->id }}"
                                                        class="text-indigo-400 hover:text-indigo-300 text-xs ml-1 underline">
                                                    Voir plus
                                                </button>
                                            @endif
                                        </td>

                                        <td class="px-4 py-3 text-right">
                                            <div class="inline-flex gap-1">
                                                <a href="{{ route('films.show', $film) }}"
                                                   class="px-2 py-1 bg-gray-700 text-gray-200 rounded text-xs hover:bg-gray-600 transition">
                                                    Voir
                                                </a>
                                                <a href="{{ route('films.edit', $film) }}"
                                                   class="px-2 py-1 bg-indigo-700 text-indigo-100 rounded text-xs hover:bg-indigo-600 transition">
                                                    Éditer
                                                </a>
                                                <form action="{{ route('films.destroy', $film) }}" method="POST" class="inline"
                                                      onsubmit="return confirm('Supprimer « {{ addslashes($film->title) }} » ?')">
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
                        Total : {{ $films->count() }} film(s)
                    </p>
                @else
                    <div class="text-center py-16 text-gray-500">
                        <p class="text-4xl mb-4">🎬</p>
                        <p class="mb-4">Aucun film pour l'instant.</p>
                        <a href="{{ route('films.create') }}"
                           class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-sm">
                            Ajouter le premier film
                        </a>
                    </div>
                @endif

            </div>
        </div>
    </div>

    <script>
        function toggleSynopsis(id) {
            const short = document.getElementById('short-' + id);
            const full  = document.getElementById('full-'  + id);
            const btn   = document.getElementById('btn-'   + id);
            const expanded = full.classList.toggle('hidden');
            short.classList.toggle('hidden');
            btn.textContent = expanded ? 'Voir plus' : 'Voir moins';
        }
    </script>
</x-app-layout>