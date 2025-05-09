<?php
require_once "app/models/SpecialMenuModel.php";

class SpecialMenuController
{
    private $SpecialMenuModel;

    public function __construct()
    {
        $this->SpecialMenuModel = new SpecialMenuModel();
    }

    public function index()
    {
      

        
       
        require_once "app/views/admin/sm/sm.php";
    }
    
   
}