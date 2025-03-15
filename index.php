<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    if (!isset($_GET["page"])) {
        include "./view/user/home/home.php";
    } else {
        $file_url = "./view/user/" . $_GET["page"] . "/" . $_GET["page"] . ".php";
        if (is_file($file_url))
            include $file_url;
        //index.php?page=blogs  -> blogs.php
        //index.php?page=introduction   -> introduction.php
        //...

        else include "./view/user/home/home.php";
    } ?>
</body>

</html>