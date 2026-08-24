<?php

namespace App\Jobs;

use App\Models\Clasher;
use App\Services\ClashOfClansService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\Middleware\ThrottlesExceptions;

class SyncAllTownHallJob implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

    /**
     * Maksimal mencoba ulang.
     */
    public int $tries = 3;

    /**
     * Timeout job.
     */
    public int $timeout = 600;

    public function middleware(): array
    {
        return [
            new WithoutOverlapping('sync-townhall'),
            new ThrottlesExceptions(5, 60),
        ];
    }

    public function handle(ClashOfClansService $coc): void
    {
        Clasher::chunkById(20, function ($clashers) use ($coc) {

            foreach ($clashers as $clasher) {

                try {

                    $player = $coc->getPlayer($clasher->tag);

                    $newTownHall = $player['townHallLevel'] ?? null;

                    if (
                        $newTownHall &&
                        $clasher->town_hall != $newTownHall
                    ) {
                        $clasher->update([
                            'town_hall' => $newTownHall,
                        ]);
                    }

                    // Jeda kecil agar tidak membanjiri API
                    usleep(200000);

                } catch (\Throwable $e) {

                    \Log::error(
                        "Gagal sync {$clasher->tag}: ".$e->getMessage()
                    );

                }

            }

        });
    }
}