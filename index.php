<?php

$rqUri = $_SERVER["REQUEST_URI"];

$routes = [
    "/webprogramming_assignment_242/blogs" => [BlogController::class, "index"],
    "/webprogramming_assignment_242/blogdetail" => [BlogController::class, "detail"],
    "/webprogramming_assignment_242/login" => [UserController::class, "login"],
    "/webprogramming_assignment_242/register" => [UserController::class, "register"],

];

foreach ($routes as $uri => $arrayCtrl) {
    $class = $arrayCtrl[0];
    $method = $arrayCtrl[1];

    $file = "app/controllers/$class.php";
    if (str_starts_with($rqUri, $uri)) {
        require_once $file;
        $obj = new $class;
        if ($method == "login" || $method == "register") {
            $obj->$method();
        } else {
            require_once "assets/components/header/header.php";
            $obj->$method();
            require_once "assets/components/footer/footer.php";
        }
        break;
    }
}
