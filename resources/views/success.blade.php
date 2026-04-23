<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-green-400">
            ✅ Paiement réussi
        </h2>
    </x-slot>

    <div class="py-10 text-center text-white">
        <div class="bg-gray-900 max-w-md mx-auto p-6 rounded-lg">

            <h3 class="text-2xl mb-4">Merci 🎉</h3>

            <p class="text-gray-400 mb-6">
                Ton abonnement a été activé avec succès.
            </p>

            <a href="/dashboard"
               class="inline-block bg-indigo-600 px-4 py-2 rounded hover:bg-indigo-700">
                Retour dashboard
            </a>

        </div>
    </div>
</x-app-layout>