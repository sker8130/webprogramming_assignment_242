<?php
require_once "app/models/BranchModel.php";
require_once "app/models/ServiceModel.php";
require_once "app/models/MemberModel.php";
session_start();

class UserIntroController
{
    private $branchModel;
    private $serviceModel;
    private $memberModel;
    public function __construct()
    {
        $this->branchModel = new BranchModel();
        $this->serviceModel = new ServiceModel();
        $this->memberModel = new MemberModel();
    }   

    public function index()
    {
        $branches = $this->branchModel->getAll();
        $specialServices = $this->serviceModel->getAll();
        $members = $this->memberModel->getAll();

        require_once "app/views/user/introduction/introduction.php";
    }
}