<?php
    include "../lib/private.php";
    session_start();
    $cfg = $config["oauth"]["github"];
    if (isset($_GET["port"])) {
        $_SESSION["port"] = $_GET["port"];
        $_SESSION["state"] = uniqid("", true);
        header("Location: https://github.com/login/oauth/authorize?client_id=${cfg["clientId"]}&redirect_uri=https://api.latipium.com/oauth/github&scope=repo&state=${_SESSION["state"]}");
    } else if (isset($_GET["code"]) && isset($_GET["state"]) && isset($_SESSION["state"]) && $_GET["state"] == $_SESSION["state"]) {
        $curl = curl_init("https://github.com/login/oauth/access_token");
        curl_setopt($curl, CURLOPT_POSTFIELDS, array(
            "client_id" => $cfg["clientId"],
            "client_secret" => $cfg["clientSecret"],
            "code" => $_GET["code"],
            "redirect_uri" => "https://api.latipium.com/oauth/github",
            "state" => $_SESSION["state"]
        ));
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            "Accept: application/json"
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $obj = json_decode(curl_exec($curl), true);
        curl_close($curl);
        $obj["port"] = $_SESSION["port"];
        header("Content-Type: application/json");
        echo json_encode($obj);
    } else {
        header("Content-Type: application/json");
        include "../404.json";
    }
?>
