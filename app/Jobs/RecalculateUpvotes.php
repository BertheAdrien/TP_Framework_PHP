<?php

// app/Jobs/RecalculateUpvotes.php

namespace App\Jobs;

use App\Models\Location;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class RecalculateUpvotes implements ShouldQueue
{
    use Queueable;

    public function __construct(public Location $location) {}

    public function handle(): void
    {
        $this->location->increment('upvotes_count');
    }
}
