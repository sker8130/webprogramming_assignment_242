<?php
require_once "app/models/HeaderModel.php";

class HeaderController
{
    private $HeaderModel;

    public function __construct()
    {
        $this->HeaderModel = new HeaderModel();
    }

    public function index()
    {
      
        $logoPath = $this->HeaderModel->getLogo();
        
       
        require_once "app/views/admin/header/header.php";
    }
    
    public function updateLogo()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
           
            if (isset($_FILES["logo"]) && $_FILES["logo"]["error"] == 0) {
                $target_dir = "assets/uploads/logo/";
                
              
                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                
           
                $file_extension = strtolower(pathinfo($_FILES["logo"]["name"], PATHINFO_EXTENSION));
                
            
                $new_filename = "logo_" . time() . "." . $file_extension;
                $target_file = $target_dir . $new_filename;
                
              
                $check = getimagesize($_FILES["logo"]["tmp_name"]);
                if ($check === false) {
                    $_SESSION["error_message"] = "File is not an image.";
                    header("Location: /webprogramming_assignment_242/admin/header");
                    exit;
                }
                
               
                if ($_FILES["logo"]["size"] > 2000000) {
                    $_SESSION["error_message"] = "Sorry, your file is too large.";
                    header("Location: /webprogramming_assignment_242/admin/header");
                    exit;
                }
                
               
                if ($file_extension != "jpg" && $file_extension != "png" && $file_extension != "jpeg" && $file_extension != "gif" && $file_extension != "svg") {
                    $_SESSION["error_message"] = "Sorry, only JPG, JPEG, PNG, GIF & SVG files are allowed.";
                    header("Location: /webprogramming_assignment_242/admin/header");
                    exit;
                }
                
            
                if (move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file)) {
                 
                    if ($this->HeaderModel->updateLogo($target_file)) {
                        $_SESSION["success_message"] = "Logo has been updated successfully.";
                    } else {
                        $_SESSION["error_message"] = "Sorry, there was an error updating the logo in database.";
                    }
                } else {
                    $_SESSION["error_message"] = "Sorry, there was an error uploading your file.";
                }
            } else {
                $_SESSION["error_message"] = "No file selected or an error occurred during upload.";
            }
            
            header("Location: /webprogramming_assignment_242/admin/header");
            exit;
        }
    }
}