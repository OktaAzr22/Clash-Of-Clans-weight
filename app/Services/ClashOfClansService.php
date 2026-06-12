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

    public function getPlayer(string $tag)
    {
        $tag = strtoupper(ltrim($tag, '#'));

        $response = $this->client()
            ->get($this->baseUrl . "/players/%23{$tag}");

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

    public function getClan(string $tag)
    {
        $tag = strtoupper(ltrim($tag, '#'));

        $response = $this->client()
            ->get($this->baseUrl . "/clans/%23{$tag}");

        if ($response->successful()) {
            return $response->json();
        }

        if ($response->status() === 404) {
            throw new Exception(
                'Clan tidak ditemukan.'
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
            'Gagal mengambil data clan.'
        );
    }
}