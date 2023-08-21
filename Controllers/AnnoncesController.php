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
        $title = "Liste des annonces";
        // compact('data') equivaut à ['annonces'=>$data]
        $this->render('annonces.index', compact(['annonces', 'title']));
    }
    public function read($id)
    {
        $id = (int)$id;
        /**
         * @var App\Models\AnnoncesModel
         */
        $annonce = $this->model->find($id);
        if (!$annonce) {
            $this->pageNotFound();
            return;
        }
        $title =  $annonce->getTitle();
        $this->render('annonces.read', compact(['annonce', 'title']));
    }
}
