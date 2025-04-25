<?php

$rqUri = $_SERVER["REQUEST_URI"];

$routes = [
    "/webprogramming_assignment_242/blogs" => [BlogController::class, "index"],
    "/webprogramming_assignment_242/blogdetail" => [BlogController::class, "detail"],
    "/webprogramming_assignment_242/login" => [AuthController::class, "login"],
    "/webprogramming_assignment_242/register" => [AuthController::class, "register"],
    "/webprogramming_assignment_242/logout" => [AuthController::class, "logout"],
    "/webprogramming_assignment_242/admin/blogs/delete" => [BlogController::class, "delete"],
    "/webprogramming_assignment_242/admin/blogs/update" => [BlogController::class, "update"],
    "/webprogramming_assignment_242/admin/blogs/add" => [BlogController::class, "add"],
    "/webprogramming_assignment_242/admin/blogs" => [BlogController::class, "adminIndex"],
    "/webprogramming_assignment_242/admin" => [AdminController::class, "index"],
    "/webprogramming_assignment_242/cart" => [CartController::class, "index"],
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