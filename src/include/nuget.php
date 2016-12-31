<?php
    define("NUGET_API_URL", "https://www.nuget.org/api/v2/");

    function nuget($endpoint, $filter, $orderby, $top, $id, $searchTerm, $includePrerelease) {
        $url = NUGET_API_URL . $endpoint;
        $querySep = '?';
        if ( $filter != null ) {
            $url .= "?\$filter=" . urlencode($filter);
            $querySep = '&';
        }
        if ( $orderby != null ) {
            $url .= "$querySep\$orderby=" . urlencode($orderby);
            $querySep = '&';
        }
        if ( $top != null ) {
            $url .= "$querySep\$top=" . urlencode($top);
            $querySep = '&';
        }
        if ( $id != null ) {
            $url .= "${querySep}id=" . urlencode($id);
            $querySep = '&';
        }
        if ( $searchTerm != null ) {
            $url .= "${querySep}searchTerm=" . urlencode($searchTerm);
            $querySep = '&';
        }
        if ( $includePrerelease != null ) {
            $url .= "${querySep}includePrerelease=" . urlencode($includePrerelease);
        }
        echo $url;
        echo file_get_contents($url);
    }
?>
