<?php
    class Config {
        public static $host = "latipium.ourproject.org";
        public static $protocol = "https";
    }

    if ( file_exists(__DIR__ . "/dev-config.php") ) {
        require_once __DIR__ . "/dev-config.php";
    }
?>
