<?php 
require_once "app/database/database.php";
?>
<?php
class ServiceModel
{
    private $db; 

    public function __construct()
    {
        $this->db = (new database())->connect();
    }

    public function add($title, $description)
    {
        $stmt = $this->db->prepare("insert into specialservice (title, description) values (?, ?)");
        $stmt->bind_param("ss", $title, $description);

        $exists = $stmt->execute();
        $stmt->close();
        return $exists;
    }

    public function update($id, $title, $description)
    {
        $stmt = $this->db->prepare("update specialservice set title = ?, description = ? where ID = ?");
        $stmt->bind_param("sss", $title, $description, $id);

        $exists = $stmt->execute();
        $stmt->close();
        return $exists;
    }

    public function delete($id) 
    {
        $stmt = $this->db->prepare("delete from specialservice where ID = ?");
        $stmt->bind_param("s", $id);
        $exists = $stmt->execute();
        $stmt->close();

        return $exists;
    }

    public function getAll()
    {
        $stmt = $this->db->prepare("select * from specialservice");
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        
        return $row;
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("select * from specialservice where id = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $row = $stmt->get_result();
        $stmt->close();

        return $row;
    }
}