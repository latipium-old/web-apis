<?php
    require_once __DIR__ . "/../../include/index.php";

    $client = new Google_Client();
    $client->setAuthConfig(__DIR__ . "/../../include/secrets.json");
    $client->addScope(Google_Service_Oauth2::PLUS_ME);
    $client->addScope(Google_Service_Oauth2::USERINFO_EMAIL);
    $client->setRedirectUri(Config::$protocol . "://" . Config::$host . "/v1/oauth");
    if ( isset($_GET["code"]) ) {
        do {
            session_destroy();
            session_id(bin2hex(openssl_random_pseudo_bytes(32)));
            session_start(array(
                "use_cookies" => 0
            ));
        } while ( isset($_SESSION["isActive"]) );
        $_SESSION["isActive"] = true;
        $client->authenticate($_GET["code"]);
        $service = new Google_Service_Oauth2(self::$client);
        $_SESSION["id"] = $service->userinfo->get()["id"];
        echo "\"" . session_id() . "\"";
    } else {
        header("Location: " . filter_var($client->createAuthUrl(), FILTER_SANITIZE_URL));
    }
?>
