<?php


namespace App\Controllers;

use App\Models\AnnoncesModel;

class AnnoncesController extends Controller
{
    public function index()
    {
        $model = new AnnoncesModel();
        $data =  $model->findAll();
        $this->render('annonces.index', compact('data'));
    }
}