<?php


namespace App\Controllers;

use App\Models\AnnoncesModel;

class AnnoncesController extends MainController
{
    private $model;
    public function __construct()
    {
        $this->model = new AnnoncesModel();
    }
    public function index()
    {
        $annonces =  $this->model->findAll();
        // compact('data') equivaut à ['annonces'=>$data]
        $this->render('annonces.index', compact('annonces'));
    }
    public function read($id)
    {
        $id = (int)$id;
        $annonce = $this->model->find($id);
        if (!$annonce) {
            $this->pageNotFound();
            return;
        }
        $this->render('annonces.read', compact('annonce'));
    }
}
