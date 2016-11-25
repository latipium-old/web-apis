<?php
    class Authentication {
        private static $client;
        private static $userInfo;

        public static function init() {
            self::$client = new Google_Client();
            self::$client->setAuthConfig(__DIR__ . "/secrets.json");
            self::$client->addScope(Google_Service_Oauth2::PLUS_ME);
            self::$client->addScope(Google_Service_Oauth2::USERINFO_EMAIL);
            self::$client->setRedirectUri(Config::$protocol . "://" . Config::$host . "/v1/callback");
            self::$client->setAccessType("offline");
            session_start();
        }

        public static function requireAuthentication() {
            if ( !(isset(self::$userInfo) && self::$userInfo) ) {
                if ( isset($_SESSION["accessToken"]) && $_SESSION["accessToken"] ) {
                    self::$client->setAccessToken($_SESSION["accessToken"]);
                    $service = new Google_Service_Oauth2(self::$client);
                    self::$userInfo = $service->userinfo->get();
                } else {
                    $auth_url = self::$client->createAuthUrl();
                    $_SESSION["returnUri"] = $_SERVER["REQUEST_URI"];
                    header("Location: " . filter_var($auth_url, FILTER_SANITIZE_URL));
                    exit();
                }
            }
            return self::$userInfo;
        }

        public static function authenticationCallback() {
            if ( isset($_GET["code"]) ) {
                self::$client->authenticate($_GET["code"]);
                $_SESSION["accessToken"] = self::$client->getAccessToken();
                if ( isset($_SESSION["returnUri"]) && $_SESSION["returnUri"] ) {
                    header("Location: " . $_SESSION["returnUri"]);
                    unset($_SESSION["returnUri"]);
                    exit();
                }
            }
            self::requireAuthentication();
        }

        public static function logout() {
            unset($_SESSION["accessToken"]);
            self::$client->revokeToken();
        }
    }

    Authentication::init();
?>
