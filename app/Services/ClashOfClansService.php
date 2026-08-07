<?php

namespace App\Services;

use Exception;
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

    protected function encodeTag(string $tag): string
    {
        return '%23' . strtoupper(ltrim(trim($tag), '#'));
    }

    public function getPlayer(string $tag): array
    {
        $response = $this->client()
            ->get(
                $this->baseUrl . '/players/' . $this->encodeTag($tag)
            );

        if ($response->successful()) {
            return $response->json();
        }

        if ($response->status() === 404) {
            throw new Exception(
                'Tag pemain tidak ditemukan.'
            );
        }

        if ($response->status() === 403) {
            throw new Exception(
                'Token API tidak valid atau IP belum didaftarkan.'
            );
        }

        if ($response->serverError()) {
            throw new Exception(
                'Server Clash of Clans sedang bermasalah.'
            );
        }

        throw new Exception(
            'Gagal mengambil data pemain.'
        );
    }

}