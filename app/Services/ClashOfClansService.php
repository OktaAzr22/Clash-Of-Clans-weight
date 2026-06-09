<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ClashOfClansService
{
    protected string $baseUrl = 'https://api.clashofclans.com/v1';

    protected function client()
    {
        return Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.coc.token'),
        ]);
    }

    public function getPlayer(string $tag)
    {
        $tag = str_replace('#', '', $tag);

        return $this->client()
            ->get($this->baseUrl . "/players/%23{$tag}")
            ->json();
    }

    public function getClan(string $tag)
    {
        $tag = str_replace('#', '', $tag);

        return $this->client()
            ->get(
                $this->baseUrl . "/clans/%23{$tag}"
            )
            ->json();
    }
}