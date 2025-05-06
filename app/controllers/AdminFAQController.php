<?php 
require_once "app/models/FAQModel.php";
session_start();

class AdminFAQController
{
    private $faqModel;

    public function __construct()
    {
        $this->faqModel = new FAQModel();
    }

    public function adminIndex()
    {
        $tableFAQHeader = "<th class='text-center'>ID</th>
                                <th class='text-center'>Question</th>
                                <th class='text-center'>Answer</th>
                                <th class='text-center'>Create At</th>
                                <th class='text-center'>Update At</th>
                                <th class='text-center'></th>";
        
        $tableFAQBody = "";
        $faqs = $this->faqModel->getAll();
        foreach($faqs as $faq){
            $tableFAQBody .= "<tr>
                                        <td id='id'>{$faq["ID"]}</td>
                                        <td>{$faq["question"]}</td>
                                        <td>{$faq["answer"]}</td>
                                        <td>{$faq["created_at"]}</td>
                                        <td>{$faq["updated_at"]}</td>
                                        <td>
                                            <a href='/webprogramming_assignment_242/admin/faq/updatefaq?id={$faq["ID"]}'
                                            class='btn btn-success'>Update</a>
                                            <a onclick='deleteConfirm({$faq['ID']})' class='btn btn-danger'>Delete</a>
                                        </td>
                                    </tr>";
        }
        require_once "app/views/admin/faq/faq.php";
    }

    public function add()
    {
        if (isset($_POST["addfaq"])) {
            $question = $_POST["question"];
            $answer = $_POST["answer"];
            if ($this->faqModel->add($question, $answer)) {
                $_SESSION['success_message'] = "Add successfully!";
                header("Location: /webprogramming_assignment_242/admin/faq");
                exit();
            }
        }
        require_once "app/views/admin/faq/addfaq.php";
    }

    public function update()
    {
        if (isset($_GET["id"])) {
            $id = $_GET["id"];
            $row = $this->faqModel->getById($id)->fetch_assoc();
        }
        if (isset($_POST["updatefaq"])) {
            $question = $_POST["question"];
            $answer = $_POST["answer"];
            if ($this->faqModel->update($id, $question, $answer)) {
                $_SESSION['success_message'] = "Update successfully!";
                header("Location: /webprogramming_assignment_242/admin/faq");
                exit();
            }
        }
        require_once "app/views/admin/faq/updatefaq.php";
    }

    public function delete()
    {
        if(isset($_GET["id"])) {
            $id = $_GET["id"];
            if($this->faqModel->delete($id)){
                $_SESSION['success_message'] = "Delete successfully!";
                header("Location: /webprogramming_assignment_242/admin/faq");
                exit();
            }
        }
        require_once "app/views/admin/faq/faq.php";
    }
}