<?php 
require_once "app/database/database.php";
?>

<?php
class FooterModel
{
    private $db;

    public function __construct()
    {
        $this->db = new database();
    }

 
    public function getFooterInfo()
    {
        $conn = $this->db->connect();
        
    
        $checkQuery = "SELECT COUNT(*) as count FROM footer";
        $checkResult = $conn->query($checkQuery);
        $row = $checkResult->fetch_assoc();
        
        if ($row['count'] == 0) {
           
            $insertQuery = "INSERT INTO footer (working_hour_1, working_hour_2, phone_1, phone_2, hotline,copyright, place_1, place_2) 
                           VALUES ('Monday - Friday: 9:00 AM - 5:00 PM', 'Saturday - Sunday: 10:00 AM - 3:00 PM', 
                                  '+1 (123) 456-7890', '+1 (123) 456-7891', '+1 (800) 123-4567'),'Copyright © 2025 Restaurant Name. All rights reserved.', 
                                  'TEST SAGON 1', 'TEST HANOI 2')";
            $conn->query($insertQuery);
        }
        
        
        $query = "SELECT * FROM footer ORDER BY id LIMIT 1";
        $result = $conn->query($query);
        
        if ($result && $result->num_rows > 0) {
            $footerInfo = $result->fetch_assoc();
            $conn->close();
            return $footerInfo;
        }
        
        $conn->close();
        return null;
    }

    public function getLogo()
    {
        $conn = $this->db->connect();
        $sql = "SELECT image_path FROM footer ORDER BY id DESC LIMIT 1";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['image_path'];
        } else {
   
            return "assets/compiled/svg/favicon.svg";
        }
    }



    public function updateLogo($imagePath)
    {
        $conn = $this->db->connect();
        $sql = "INSERT INTO footer (image_path) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $imagePath);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

 
    public function updateFooter($working_hour_1, $working_hour_2, $phone_1, $phone_2, $hotline,$copyright, $place_1, $place_2)
    {
        $conn = $this->db->connect();
        
    
        $working_hour_1 = $conn->real_escape_string($working_hour_1);
        $working_hour_2 = $conn->real_escape_string($working_hour_2);
        $phone_1 = $conn->real_escape_string($phone_1);
        $phone_2 = $conn->real_escape_string($phone_2);
        $hotline = $conn->real_escape_string($hotline);
        $copyright = $conn->real_escape_string($copyright);
        $place_1 = $conn->real_escape_string($place_1);
        $place_2 = $conn->real_escape_string($place_2);
        
    
        $checkQuery = "SELECT id FROM footer LIMIT 1";
        $checkResult = $conn->query($checkQuery);
        
        if ($checkResult && $checkResult->num_rows > 0) {
      
            $row = $checkResult->fetch_assoc();
            $id = $row['id'];
            
            $query = "UPDATE footer SET 
                      working_hour_1 = '$working_hour_1',
                      working_hour_2 = '$working_hour_2',
                      phone_1 = '$phone_1',
                      phone_2 = '$phone_2',
                      hotline = '$hotline',
                      copyright = '$copyright',
                      place_1 = '$place_1',
                      place_2 = '$place_2'
                      WHERE id = $id";
        } else {
            
            $query = "INSERT INTO footer (working_hour_1, working_hour_2, phone_1, phone_2, hotlin,copyright, place_1, place_2) 
                     VALUES ('$working_hour_1', '$working_hour_2', '$phone_1', '$phone_2', '$hotline','$copyright', '$place_1', '$place_2')";
        }
        
        $result = $conn->query($query);
        $conn->close();
        
        return $result ? true : false;
    }
}