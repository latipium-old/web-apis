<?php
    if ( isset($_SERVER["HTTP_REFERER"]) && $_SERVER["HTTP_REFERER"] != "latipium.com" ) {
        header("Location: https://latipium.com/");
        exit();
    }
    if ( isset($_SERVER["HTTP_ORIGIN"]) ) {
        if ( $_SERVER["HTTP_ORIGIN"] == "latipium.com" ) {
            header("Access-Control-Allow-Origin: latipium.com");
        } else {
            header("Location: https://latipium.com/");
            exit();
        }
    }
    if ( isset($_SERVER["HTTP_ACCESS_CONTROL_REQUEST_METHOD"]) ) {
        header("Access-Control-Allow-Methods: " . $_SERVER["HTTP_ACCESS_CONTROL_REQUEST_METHOD"]);
    }
    if ( isset($_SERVER["HTTP_ACCESS_CONTROL_REQUEST_HEADERS"]) ) {
        header("Access-Control-Allow-Headers: " . $_SERVER["HTTP_ACCESS_CONTROL_REQUEST_HEADERS"]);
    }
    header("Access-Control-Max-Age: 600");
?>