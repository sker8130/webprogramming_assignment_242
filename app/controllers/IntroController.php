<?php
require_once "app/models/BranchModel.php";
require_once "app/models/ServiceModel.php";
require_once "app/models/MemberModel.php";


class IntroController
{
    private $branchModel;
    private $serviceModel;
    private $memberModel;
    private $allBranches;
    private $allServices;
    private $allMembers;
    public function __construct()
    {
        $this->branchModel = new BranchModel();
        $this->serviceModel = new ServiceModel();
        $this->memberModel = new MemberModel();

        $this->allBranches = $this->branchModel->getAll();
        $this->allServices = $this->serviceModel->getAll();
        $this->allMembers = $this->memberModel->getAll();
    }

    public function index()
    {
        require_once "app/views/admin/introduction/introduction.php";
    }
}