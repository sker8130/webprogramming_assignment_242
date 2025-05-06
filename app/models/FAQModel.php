<?php 
require_once "app/database/database.php";
?>

<?php
class FAQModel
{
    private $db;

    public function __construct()
    {
        $this->db = (new database())->connect();
    }

    public function add($question, $answer)
    {
        $stmt = $this->db->prepare("insert into fanda (question, answer) values (?, ?)");
        $stmt->bind_param("ss", $question, $answer);

        $exists = $stmt->execute();
        $stmt->close();

        return $exists;
    }

    public function update($id, $question, $answer){
        $stmt = $this->db->prepare("update fanda set question = ?, answer = ? where ID = ?");
        $stmt->bind_param("sss", $question, $answer, $id);

        $exists = $stmt->execute();
        $stmt->close();
        return $exists;
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("delete from fanda where ID = ?");
        $stmt->bind_param("s", $id);
        $exists = $stmt->execute();
        $stmt->close();

        return $exists;
    }

    public function getAll()
    {
        $stmt = $this->db->prepare("select * from fanda");
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        
        return $row;
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("select * from fanda where id = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $row = $stmt->get_result();
        $stmt->close();

        return $row;
    }
}