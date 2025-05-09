<?php
require_once "app/models/PopularDishesModel.php";

class PopularDishesController
{
    private $PopularDishesModel;

    public function __construct()
    {
        $this->PopularDishesModel = new PopularDishesModel();
    }

    public function index()
    {
      

        
       
        require_once "app/views/admin/pd/pd.php";
    }
    
   
}