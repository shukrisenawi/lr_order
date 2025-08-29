<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Http;
use App\Models\Bisnes;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public $bisnes_id;

    public function __construct()
    {
        $this->bisnes_id = session('selected_bisnes_id');
    }

    public function sentN8n($link_test, $link_production, $data, $test = true)
    {
        $data['sessionId'] = uniqid();
        if (env('APP_DEV') && $test) {
            $response = Http::withoutVerifying()->get(
                $link_test,
                $data
            );
        } else {
            $response = Http::get(
                $link_production,
                $data
            );
        }
        return $response->json();
    }

    public function generateSummary(Bisnes $bisnes)
    {
        exit;
        $system_message = $bisnes->system_message;
        $product = $bisnes->produk()->all();
        $gambar = $bisnes->gambar()->where('ai_search', 1)->all();

        $produkList = count($product) > 0
            ? implode("\n", array_map(function ($p) {
                return "- Nama Produk : " . $p->nama
                    . ", Gambar : " . $p->gambar->path
                    . ", Harga : " . $p->harga
                    . ", Maklumat Produk : " . $p->info;
            }, $product))
            : "Tiada produk didaftarkan.";

        $gambarList = count($gambar) > 0
            ? implode("\n", array_map(function ($g) {
                return "- Tajuk : " . $g->nama
                    . ", Keterangan : " . $g->keterangan
                    . ", Gambar : " . $g->path;
            }, $gambar))
            : "Tiada gambar didaftarkan.";

        $summary = <<<EOD
                    $system_message

                    PRODUK SYARIKAT
                    $produkList

                    GAMBAR BERKAITAN
                    $gambarList
                    EOD;

        $bisnes->summary = $summary;
        $bisnes->save();
        return true;
    }
}
