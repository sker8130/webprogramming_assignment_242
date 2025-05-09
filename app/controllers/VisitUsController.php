<?php
require_once "app/models/VisitUsModel.php";

class VisitUsController
{
    private $VisitUsModel;

    public function __construct()
    {
        $this->VisitUsModel = new VisitUsModel();
    }

    public function index()
    {
      

        
       
        require_once "app/views/admin/visit-us/visit-us.php";
    }
    
   
}