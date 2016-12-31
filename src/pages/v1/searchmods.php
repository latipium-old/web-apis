<?php
    define("LATIPIUM_DO_NOT_REQUIRE_AUTHENTICATION", true);
    require_once __DIR__ . "/../../include/index.php";

    nuget("Search", "(substringof(' Latipium ', Tags) or startswith(Tags, 'Latipium ') or endswith(Tags, ' Latipium') or Tags eq 'Latipium') and IsLatestVersion", "DownloadCount desc", null, null, $_REQUEST["term"], $_REQUEST["prerelease"] == "true");
?>
