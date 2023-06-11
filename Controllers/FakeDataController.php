<?php

namespace App\Controllers;

use App\Models\AnnoncesModel;

class FakeDataController extends Controller
{
    public function addFakeAnnonce()
    {
        $filePath = ROOT_LIBS . 'data' . DS . 'fake-data.json';
        $fileData = json_decode(file_get_contents($filePath));
        $fakeData = [];
        foreach ($fileData as $k => $data) {
            $fakeData[$k]['title'] = $data->title;
            $fakeData[$k]['description'] = $data->body;
            $fakeData[$k]['active'] = (int)mt_rand(0, 1);
            $fakeData[$k]['createdAt'] = randomDate('2020-06-11', '2023-06-11');
        }
        debugPrint($fakeData);

        $model = new AnnoncesModel();
        foreach ($fakeData as $data) {
            $model->hydrateData($data)->create();
        }
    }
}
