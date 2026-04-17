<?php

namespace App\Console\Commands;

use App\Models\Location;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CleanOldLocations extends Command
{
    protected $signature = 'locations:clean';

    protected $description = 'Supprime les locations de plus de 14 jours avec moins de 2 upvotes';

    public function handle()
    {
        // Date limite (14 jours)
        $limitDate = Carbon::now()->subDays(14);

        // Récupérer les locations à supprimer
        $locations = Location::where('created_at', '<', $limitDate)
            ->where('upvotes_count', '<', 2)
            ->get();

        $count = $locations->count();

        // Suppression
        foreach ($locations as $location) {
            $location->delete();
        }

        // Message console
        $this->info("$count location(s) supprimée(s)");

        return Command::SUCCESS;
    }
}
