<?php
    if ( isset($_GET["authToken"]) ) {
        session_id($_GET["authToken"]);
        session_start(array(
            "use_cookies" => 0
        ));
        if ( isset($_SESSION["id"]) ) {
            $reqBody = file_get_contents("php://input");
            $subject = openssl_csr_get_subject($reqBody);
            if ( $subject ) {
                if ( isset($subject["C"]) && $subject["O"] == "Latipium" && $subject["OU"] == "Google OAuth" && $subject["CN"] == $_SESSION["id"] ) {
                    $intId = date("Ym");
                    $intPriv = null;
                    if ( file_exists(__DIR__ . "/../../../.keys/$intId.key") ) {
                        $intPriv = openssl_pkey_get_private(file_get_contents(__DIR__ . "/../../../.keys/$intId.key"));
                    } else {
                        $lock = fopen(__DIR__ . "/../../../.keys/$intId.key.lock", "w");
                        flock($lock, LOCK_EX);
                        if ( !file_exists(__DIR__ . "/../../../.keys/$intId.key") ) {
                            $intPriv = openssl_pkey_new(array(
                                "private_key_bits" => 2048
                            ));
                            openssl_pkey_export($intPriv, $privExport);
                            file_put_contents(__DIR__ . "/../../../.keys/$intId.key", $privExport);
                            chmod(__DIR__ . "/../../../.keys/$intId.key", 0400);
                        }
                        flock($lock, LOCK_UN);
                        fclose($lock);
                        unlink(__DIR__ . "/../../../.keys/$intId.key.lock");
                    }
                    $intCert = null;
                    if ( file_exists(__DIR__ . "/../../../.keys/$intId.pem") ) {
                        $intCert = openssl_x509_read(file_get_contents(__DIR__ . "/../../../.keys/$intId.pem"));
                    } else {
                        $lock = fopen(__DIR__ . "/../../../.keys/$intId.pem.lock", "w");
                        flock($lock, LOCK_EX);
                        if ( !file_exists(__DIR__ . "/../../../.keys/$intId.pem") ) {
                            $caPriv = openssl_pkey_get_private(file_get_contents(__DIR__ . "/../../../.keys/ca.key"));
                            $caCert = openssl_x509_read(file_get_contents(__DIR__ . "/../../../.keys/ca.pem"));
                            $csr = openssl_csr_new(array(
                                "countryName" => "US",
                                "organizationName" => "Latipium",
                                "organizationalUnitName" => "Intermediate",
                                "commonName" => "latipium.com",
                                "emailAddress" => "help@latipium.com"
                            ), $intPriv);
                            $intCert = openssl_csr_sign($csr, $caCert, $caPriv, 31);
                            openssl_pkey_free($caPriv);
                            openssl_x509_free($caCert);
                            openssl_x509_export_to_file($intCert, __DIR__ . "/../../../.keys/$intId.pem");
                            chmod(__DIR__ . "/../../../.keys/$intId.pem", 0400);
                        }
                        flock($lock, LOCK_UN);
                        fclose($lock);
                        unlink(__DIR__ . "/../../../.keys/$intId.pem.lock");
                    }
                    $cert = openssl_csr_sign($reqBody, $intCert, $intPriv, 365);
                    openssl_pkey_free($intPriv);
                    openssl_x509_free($intCert);
                    openssl_x509_export($cert, $certExport);
                    openssl_x509_free($cert);
                    echo $certExport;
                } else {
                    echo "Invalid subject";
                }
            } else {
                echo "Invalid cert";
            }
        } else {
            echo "Authentication failed";
        }
    } else {
        echo "Authentication required";
    }
?>
