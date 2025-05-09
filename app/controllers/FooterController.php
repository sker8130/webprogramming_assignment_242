<?php
require_once "app/models/FooterModel.php";

class FooterController
{
    private $FooterModel;

    public function __construct()
    {
        $this->FooterModel = new FooterModel();
    }

    public function index()
    {
      

        
       
        require_once "app/views/admin/footer/footer.php";
    }
    
   
}