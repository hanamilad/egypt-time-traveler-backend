<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Visa;
use App\Models\BestTime;
use App\Models\Season;
use App\Models\Packing;
use App\Models\PackingCategory;
use App\Models\Etiquette;
use App\Models\EtiquetteTip;

class TravelInfoController extends Controller
{
    public function show()
    {
        $visa = Visa::query()->first();
        $best = BestTime::query()->first();
        $packing = Packing::query()->first();
        $etiquette = Etiquette::query()->first();

        $seasons = [];
        if ($best) {
            $seasonRows = Season::query()->where('best_time_id', $best->id)->get();
            foreach ($seasonRows as $s) {
                $key = is_string($s->season_name) ? $s->season_name : 'season_' . $s->id;
                $seasons[$key] = [
                    'name_en' => $s->name_en,
                    'name_de' => $s->name_de,
                    'description_en' => $s->description_en,
                    'description_de' => $s->description_de,
                ];
            }
        }

        $categories = [];
        if ($packing) {
            $cats = PackingCategory::query()->where('packing_id', $packing->id)->get();
            foreach ($cats as $c) {
                $key = strtolower(str_replace(' ', '_', $c->name_en));
                $categories[] = [
                    'key' => $key,
                    'name_en' => $c->name_en,
                    'name_de' => $c->name_de,
                    'items_en' => $c->items_en ?? [],
                    'items_de' => $c->items_de ?? [],
                ];
            }
        }


        $tips = [];
        if ($etiquette) {
            $tipsRows = EtiquetteTip::query()->where('etiquette_id', $etiquette->id)->get();
            foreach ($tipsRows as $t) {
                $tips[] = [
                    'title_en' => $t->title_en,
                    'title_de' => $t->title_de,
                    'description_en' => $t->description_en,
                    'description_de' => $t->description_de,
                ];
            }
        }

        return response()->json([
            'visa' => [
                'title_en' => $visa?->title_en,
                'title_de' => $visa?->title_de,
                'intro_en' => $visa?->intro_en,
                'intro_de' => $visa?->intro_de,
                'items_en' => $visa?->items_en ?? [],
                'items_de' => $visa?->items_de ?? [],
            ],
            'bestTime' => [
                'title_en' => $best?->title_en,
                'title_de' => $best?->title_de,
                'intro_en' => $best?->intro_en,
                'intro_de' => $best?->intro_de,
                'seasons' => $seasons,
            ],
            'packing' => [
                'title_en' => $packing?->title_en,
                'title_de' => $packing?->title_de,
                'intro_en' => $packing?->intro_en,
                'intro_de' => $packing?->intro_de,
                'categories' => $categories,
            ],
            'etiquette' => [
                'title_en' => $etiquette?->title_en,
                'title_de' => $etiquette?->title_de,
                'intro_en' => $etiquette?->intro_en,
                'intro_de' => $etiquette?->intro_de,
                'tips' => $tips,
            ],
        ]);
    }
}
