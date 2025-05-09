<?php
require_once "app/models/BannerModel.php";

class BannerController
{
    private $BannerModel;

    public function __construct()
    {
        $this->BannerModel = new BannerModel();
    }

    public function index()
    {
      
        $logoPath = $this->BannerModel->getLogo();
        
       
        require_once "app/views/admin/banner/banner.php";
    }
    
    public function updateLogo()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
           
            if (isset($_FILES["banner"]) && $_FILES["banner"]["error"] == 0) {
                $target_dir = "assets/uploads/banner/";
                
              
                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                
           
                $file_extension = strtolower(pathinfo($_FILES["banner"]["name"], PATHINFO_EXTENSION));
                
            
                $new_filename = "banner_" . time() . "." . $file_extension;
                $target_file = $target_dir . $new_filename;
                
              
                $check = getimagesize($_FILES["banner"]["tmp_name"]);
                if ($check === false) {
                    $_SESSION["error_message"] = "File is not an image.";
                    header("Location: /webprogramming_assignment_242/admin/banner");
                    exit;
                }
                
               
                if ($_FILES["banner"]["size"] > 2000000) {
                    $_SESSION["error_message"] = "Sorry, your file is too large.";
                    header("Location: /webprogramming_assignment_242/admin/banner");
                    exit;
                }
                
               
                if ($file_extension != "jpg" && $file_extension != "png" && $file_extension != "jpeg" && $file_extension != "gif" && $file_extension != "svg") {
                    $_SESSION["error_message"] = "Sorry, only JPG, JPEG, PNG, GIF & SVG files are allowed.";
                    header("Location: /webprogramming_assignment_242/admin/banner");
                    exit;
                }
                
            
                if (move_uploaded_file($_FILES["banner"]["tmp_name"], $target_file)) {
                 
                    if ($this->BannerModel->updateLogo($target_file)) {
                        $_SESSION["success_message"] = "Logo has been updated successfully.";
                    } else {
                        $_SESSION["error_message"] = "Sorry, there was an error updating the banner in database.";
                    }
                } else {
                    $_SESSION["error_message"] = "Sorry, there was an error uploading your file.";
                }
            } else {
                $_SESSION["error_message"] = "No file selected or an error occurred during upload.";
            }
            
            header("Location: /webprogramming_assignment_242/admin/banner");
            exit;
        }
    }
}