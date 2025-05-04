<?php
require_once "app/models/BranchModel.php";
require_once "app/models/ServiceModel.php";
require_once "app/models/MemberModel.php";
session_start();

class AdminIntroController
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

    public function adminIndex()
    {
        $tableBranchHeader = "<th class='text-center'>ID</th>
                                <th class='text-center'>Location</th>
                                <th class='text-center'>Description</th>
                                <th class='text-center'>Image</th>
                                <th class='text-center'></th>";
        $tableBranchBody = "";
        $branches = $this->branchModel->getAll();
        foreach($branches as $branch){
            $tableBranchBody .= "<tr>
                                        <td id='id'>{$branch["ID"]}</td>
                                        <td>{$branch["location"]}</td>
                                        <td>{$branch["description"]}</td>
                                        <td><img src='{$branch["image"]}' alt='idk' width='100'></td>
                                        <td>
                                            <a href='/webprogramming_assignment_242/admin/introduction/updatebranch?id={$branch["ID"]}'
                                            class='btn btn-success'>Update</a>
                                            <a onclick='deleteConfirmBranch({$branch['ID']})' class='btn btn-danger'>Delete</a>
                                        </td>
                                    </tr>";
        }


        $tableServiceHeader = "<th class='text-center'>ID</th>
                                <th class='text-center'>Title</th>
                                <th class='text-center'>Description</th>
                                <th class='text-center'></th>";
        $tableServiceBody = "";
        $specialServices = $this->serviceModel->getAll();
        foreach($specialServices as $service){
            $tableServiceBody .= "<tr>
                                        <td id='id'>{$service["ID"]}</td>
                                        <td>{$service["title"]}</td>
                                        <td>{$service["description"]}</td>
                                        <td>
                                            <a href='/webprogramming_assignment_242/admin/introduction/updateservice?id={$service["ID"]}'
                                            class='btn btn-success'>Update</a>
                                            <a onclick='deleteConfirmService({$service['ID']})' class='btn btn-danger'>Delete</a>
                                        </td>
                                    </tr>";
        }

        $tableMemberHeader = "<th class='text-center'>ID</th>
                                <th class='text-center'>Position</th>
                                <th class='text-center'>Name</th>
                                <th class='text-center'>Description</th>
                                <th class='text-center'></th>";
        $tableMemberBody = "";
        $members = $this->memberModel->getAll();
        foreach($members as $member){
            $tableMemberBody .= "<tr>
                                        <td id='id'>{$member["ID"]}</td>
                                        <td>{$member["position"]}</td>
                                        <td>{$member["name"]}</td>
                                        <td>{$member["description"]}</td>
                                        <td>
                                            <a href='/webprogramming_assignment_242/admin/introduction/updatemember?id={$member["ID"]}'
                                            class='btn btn-success'>Update</a>
                                            <a onclick='deleteConfirmMember({$member['ID']})' class='btn btn-danger'>Delete</a>
                                        </td>
                                    </tr>";
        }
        require_once "app/views/admin/introduction/introduction.php";
    }

    public function addbranch()
    {
        if (isset($_POST["addbranch"])) {
            if ($this->branchModel->add($_FILES, $_POST)) {
                $_SESSION['success_message'] = "Add successfully!";
                header("Location: /webprogramming_assignment_242/admin/introduction");
                exit();
            }
        }
        require_once "app/views/admin/introduction/addbranch.php";
    }

    public function updatebranch()
    {
        if (isset($_GET["id"])) {
            $id = $_GET["id"];
            $row = $this->branchModel->getById($id)->fetch_assoc();
        }
        if (isset($_POST["updatebranch"])) { 
            if ($this->branchModel->update($id, $_FILES, $_POST)) {
                $_SESSION['success_message'] = "Update successfully!";
                header("Location: /webprogramming_assignment_242/admin/introduction");
                exit();
            }
        }
        require_once "app/views/admin/introduction/updatebranch.php"; 
    }
    public function deletebranch()
    {
        if(isset($_GET["id"])) {
            $id = $_GET["id"];
            if($this->branchModel->delete($id)){
                $_SESSION['success_message'] = "Delete successfully!";
                header("Location: /webprogramming_assignment_242/admin/introduction");
                exit();
            }
        }
        require_once "app/views/admin/introduction/introduction.php";
    }

    public function addservice()
    {
        if (isset($_POST["addservice"])) {
            $title = $_POST["title"];
            $description = $_POST["description"];
            if ($this->serviceModel->add($title, $description)) {
                $_SESSION['success_message'] = "Add successfully!";
                header("Location: /webprogramming_assignment_242/admin/introduction");
                exit();
            }
        }
        require_once "app/views/admin/introduction/addservice.php";
    }

    public function updateservice()
    {
        if (isset($_GET["id"])) {
            $id = $_GET["id"];
            $row = $this->serviceModel->getById($id)->fetch_assoc();
        }
        if (isset($_POST["updateservice"])) {
            $title = $_POST["title"];
            $description = $_POST["description"];
            if ($this->serviceModel->update($id, $title, $description)) {
                $_SESSION['success_message'] = "Update successfully!";
                header("Location: /webprogramming_assignment_242/admin/introduction");
                exit();
            }
        }
        require_once "app/views/admin/introduction/updateservice.php";
    }
    public function deleteservice()
    {
        if(isset($_GET["id"])) {
            $id = $_GET["id"];
            if($this->serviceModel->delete($id)){
                $_SESSION['success_message'] = "Delete successfully!";
                header("Location: /webprogramming_assignment_242/admin/introduction");
                exit();
            }
        }
        require_once "app/views/admin/introduction/introduction.php";
    }

    public function addmember()
    {
        if (isset($_POST["addmember"])) {
            $position = $_POST["position"];
            $name = $_POST["name"];
            $description = $_POST["description"];
            if ($this->memberModel->add($position,$name, $description)) {
                $_SESSION['success_message'] = "Add successfully!";
                header("Location: /webprogramming_assignment_242/admin/introduction");
                exit();
            }
        }
        require_once "app/views/admin/introduction/addmember.php";
    }

    public function updatemember()
    {
        if (isset($_GET["id"])) {
            $id = $_GET["id"];
            $row = $this->memberModel->getById($id)->fetch_assoc();
        }
        if (isset($_POST["updatemember"])) { 
            $position = $_POST["position"];
            $name = $_POST["name"];
            $description = $_POST["description"];
            if ($this->memberModel->update($id, $position, $name,$description)) {
                $_SESSION['success_message'] = "Update successfully!";
                header("Location: /webprogramming_assignment_242/admin/introduction");
                exit();
            }
        }
        require_once "app/views/admin/introduction/updatemember.php";
    }
    public function deletemember()
    {
        if(isset($_GET["id"])) {
            $id = $_GET["id"];
            if($this->memberModel->delete($id)){
                $_SESSION['success_message'] = "Delete successfully!";
                header("Location: /webprogramming_assignment_242/admin/introduction");
                exit();
            }
        }
        require_once "app/views/admin/introduction/introduction.php";
    }
} 