<?php

$rqUri = $_SERVER["REQUEST_URI"];

$routes = [
    "/webprogramming_assignment_242/blogs" => [BlogController::class, "index"],
    "/webprogramming_assignment_242/blogdetail" => [BlogController::class, "detail"],

];

foreach ($routes as $uri => $arrayCtrl) {
    $class = $arrayCtrl[0];
    $method = $arrayCtrl[1];

    $file = "app/controllers/$class.php";
    if (str_starts_with($rqUri, $uri)) {
        require_once $file;
        $obj = new $class;
        $obj->$method();
        break;
    }
}
