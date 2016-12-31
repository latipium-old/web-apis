<?php
    define("LATIPIUM_DO_NOT_REQUIRE_AUTHENTICATION", true);
    require_once __DIR__ . "/../../include/index.php";

    nuget("FindPackagesById", "Version eq '${_REQUEST["version"]}'", null, null, "'${_REQUEST["id"]}'", null, null);
?>
