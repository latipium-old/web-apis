<?php
    require_once __DIR__ . "/../../include/index.php";

    if ( !(isset($_GET["skipAuth"]) && $_GET["skipAuth"] == "true") ) {
        Authentication::requireAuthentication();
    }
    header("Location: " . $_GET["url"]);
?>
