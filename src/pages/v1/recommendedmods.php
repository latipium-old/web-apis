<?php
    define("LATIPIUM_DO_NOT_REQUIRE_AUTHENTICATION", true);
    require_once __DIR__ . "/../../include/index.php";

    nuget("Packages", "(substringof(' Latipium ', Tags) or startswith(Tags, 'Latipium ') or endswith(Tags, ' Latipium') or Tags eq 'Latipium') and IsLatestVersion and (not IsPrerelease) and not substringof(concat(concat(' ', Id), ' '), ' ${_REQUEST["mods"]} ')", "DownloadCount desc", "10", null, null, null);
?>
