<?php
    require_once __DIR__ . "/../../include/index.php";

    echo json_encode(Authentication::requireAuthentication());
?>
