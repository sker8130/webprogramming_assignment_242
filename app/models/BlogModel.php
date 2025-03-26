<?php

require_once "app/database/database.php"

?>

<?php

class BlogModel
{
    private static $db;

    public function __construct()
    {
        self::$db = new database();
    }

    // public static function list()
    // {
    //     $query = "select * from account";
    //     return self::$db->select($query);
    // }
}
