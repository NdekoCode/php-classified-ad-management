<?php


namespace App\Controllers;

use App\Models\AnnoncesModel;

class AnnoncesController extends Controller
{
    public function index()
    {
        $model = new AnnoncesModel();
        $annonces =  $model->findAll();
        // compact('data') equivaut à ['annonces'=>$data]
        $this->render('annonces.index', compact('annonces'));
    }
}
