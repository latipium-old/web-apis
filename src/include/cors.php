<?php
    if ( isset($_SERVER["HTTP_REFERER"]) ) {
        $host = parse_url($_SERVER["HTTP_REFERER"], PHP_URL_HOST);
        if ( $host != "accounts.google.com" && $host != "latipium.com" && $host != "www.latipium.com" && $host != "localhost" ) {
            header("Location: https://latipium.com/");
            exit();
        }
    }
    if ( isset($_SERVER["HTTP_ORIGIN"]) ) {
        $host = parse_url($_SERVER["HTTP_ORIGIN"], PHP_URL_HOST);
        if ( $host == "latipium.com" || $host == "www.latipium.com" || $host == "localhost" ) {
            $port = parse_url($_SERVER["HTTP_ORIGIN"], PHP_URL_PORT);
            header("Access-Control-Allow-Origin: " . $host . ($port == "" ? "" : ":" . $port));
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
    header("Access-Control-Allow-Credentials: true");
?>
