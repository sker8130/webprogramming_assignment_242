<?php

require_once "app/database/database.php";

?>

<?php

class MemberModel
{
    private $db;

    public function __construct()
    {
        $this->db = (new database())->connect();
    }

    public function add($position, $name, $description)
    {
        $stmt = $this->db->prepare("insert into members (position, name, description) values (?, ?, ?)");
        $stmt->bind_param("sss", $position, $name, $description);

        $exists = $stmt->execute();
        $stmt->close();

        return $exists;
    }

    public function update($id, $position, $name, $description)
    {
        $stmt = $this->db->prepare("update members set position = ?, name = ?, description = ? where ID = ?");
        $stmt->bind_param("sssi", $position, $name, $description, $id);

        $exists = $stmt->execute();
        $stmt->close();
        return $exists;
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("delete from members where ID = ?");
        $stmt->bind_param("i", $id);
        $exists = $stmt->execute();
        $stmt->close();

        return $exists;
    }

    public function getAll()
    {
        $stmt = $this->db->prepare("select * from members");
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $row;
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("select * from members where id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $row = $stmt->get_result();
        $stmt->close();

        return $row;
    }
}