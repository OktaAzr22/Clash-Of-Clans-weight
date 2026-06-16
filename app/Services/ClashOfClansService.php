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

    public function getClan(string $tag): array
    {
        $response = $this->client()
            ->get(
                $this->baseUrl . '/clans/' . $this->encodeTag($tag)
            );

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

    public function getClanMembers(string $tag): array
    {
        $response = $this->client()
            ->get(
                $this->baseUrl .
                '/clans/' .
                $this->encodeTag($tag) .
                '/members'
            );

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
            'Gagal mengambil anggota clan.'
        );
    }

    public function getCurrentWar(string $tag): ?array
    {
        $response = $this->client()
            ->get(
                $this->baseUrl .
                '/clans/' .
                $this->encodeTag($tag) .
                '/currentwar'
            );

        if ($response->successful()) {
            return $response->json();
        }

        /*
         * Current war mengembalikan 404 apabila:
         * - Clan tidak sedang war
         * - War log bersifat private
         * - Clan tidak ditemukan
         *
         * Untuk monitoring, kita anggap tidak ada war aktif.
         */
        if ($response->status() === 404) {
            return null;
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
            'Gagal mengambil data current war.'
        );
    }
}