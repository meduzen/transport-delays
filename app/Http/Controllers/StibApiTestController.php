<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class StibApiTestController extends Controller
{
    public function __invoke()
    {
        $data = Http::get('https://data.stib-mivb.brussels/api/explore/v2.1/catalog/datasets/travellers-information-rt-production/records?limit=20');
        $data_full = Http::get('https://data.stib-mivb.brussels/api/explore/v2.1/catalog/datasets/travellers-information-rt-production/exports/json?lang=en&timezone=Europe%2FBrussels');

        dd($data->json(), $data_full->json());
    }
}
