<?php

$rqUri = $_SERVER["REQUEST_URI"];

$routes = [
    // url cho admin site
    "/webprogramming_assignment_242/admin/users/delete" => [UserController::class, "delete"],
    "/webprogramming_assignment_242/admin/users/update" => [UserController::class, "update"],
    "/webprogramming_assignment_242/admin/users" => [UserController::class, "adminIndex"],

    "/webprogramming_assignment_242/admin/comments/delete" => [CommentController::class, "delete"],
    "/webprogramming_assignment_242/admin/comments" => [CommentController::class, "adminIndex"],

    "/webprogramming_assignment_242/admin/blogs/delete" => [BlogController::class, "delete"],
    "/webprogramming_assignment_242/admin/blogs/update" => [BlogController::class, "update"],
    "/webprogramming_assignment_242/admin/blogs/add" => [BlogController::class, "add"],
    "/webprogramming_assignment_242/admin/blogs" => [BlogController::class, "adminIndex"],

    "/webprogramming_assignment_242/admin/introduction/addbranch" => [AdminIntroController::class, "addbranch"],
    "/webprogramming_assignment_242/admin/introduction/updatebranch" => [AdminIntroController::class, "updatebranch"],
    "/webprogramming_assignment_242/admin/introduction/deletebranch" => [AdminIntroController::class, "deletebranch"],
    "/webprogramming_assignment_242/admin/introduction/addservice" => [AdminIntroController::class, "addservice"],
    "/webprogramming_assignment_242/admin/introduction/updateservice" => [AdminIntroController::class, "updateservice"],
    "/webprogramming_assignment_242/admin/introduction/deleteservice" => [AdminIntroController::class, "deleteservice"],
    "/webprogramming_assignment_242/admin/introduction/addmember" => [AdminIntroController::class, "addmember"],
    "/webprogramming_assignment_242/admin/introduction/updatemember" => [AdminIntroController::class, "updatemember"],
    "/webprogramming_assignment_242/admin/introduction/deletemember" => [AdminIntroController::class, "deletemember"],
    "/webprogramming_assignment_242/admin/introduction" => [AdminIntroController::class, "adminIndex"],

    "/webprogramming_assignment_242/admin/faq/addfaq" => [AdminFAQController::class, "add"],
    "/webprogramming_assignment_242/admin/faq/updatefaq" => [AdminFAQController::class, "update"],
    "/webprogramming_assignment_242/admin/faq/deletefaq" => [AdminFAQController::class, "delete"],
    "/webprogramming_assignment_242/admin/faq" => [AdminFAQController::class, "adminIndex"],

    "/webprogramming_assignment_242/admin" => [AdminController::class, "index"],


    // url cho guest/member site
    "/webprogramming_assignment_242/contact" => [ContactController::class, "index"],
    "/webprogramming_assignment_242/blogs" => [BlogController::class, "index"],
    "/webprogramming_assignment_242/blog" => [BlogController::class, "detail"],
    "/webprogramming_assignment_242/login" => [AuthController::class, "login"],
    "/webprogramming_assignment_242/register" => [AuthController::class, "register"],
    "/webprogramming_assignment_242/logout" => [AuthController::class, "logout"],
    "/webprogramming_assignment_242/items" => [ItemsController::class, "index"],
    "/webprogramming_assignment_242/itemdetail" => [ItemsController::class, "detail"],
    "/webprogramming_assignment_242/cart" => [CartController::class, "index"],
    "/webprogramming_assignment_242/introduction" => [UserIntroController::class, "index"],
    "/webprogramming_assignment_242/faq" => [UserFAQController::class, "index"],
    "/webprogramming_assignment_242/" => [HomeController::class, "index"],
];

foreach ($routes as $uri => $arrayCtrl) {
    $class = $arrayCtrl[0];
    $method = $arrayCtrl[1];

    $file = "app/controllers/$class.php";
    if (str_starts_with($rqUri, $uri)) {
        require_once $file;
        $obj = new $class;
        if ($method == "login" || $method == "register" || strpos($uri, "admin")) {
            $obj->$method();
        } else {
            require_once "assets/components/header/header.php";
            $obj->$method();
            require_once "assets/components/footer/footer.php";
        }
        break;
    }
}
