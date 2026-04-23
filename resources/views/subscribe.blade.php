<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            💳 Abonnement Premium
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-md mx-auto bg-gray-900 p-6 rounded-lg text-center text-white">

            <h3 class="text-2xl mb-4">Pass Premium</h3>

            <p class="text-gray-400 mb-6">
                Accédez à l’API complète des films et locations.
            </p>

            <form method="POST" action="/create-checkout-session">
                @csrf

                <button class="w-full bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded">
                    Payer 5€
                </button>
            </form>

        </div>
    </div>
</x-app-layout>