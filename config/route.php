<?php

function route($path = "", $params = [])
{
    // Base URL of your PUBLIC folder only
    $base = "http://localhost/Disaster-Response-System/public/";
    // Clean the path
    $path = trim($path, "/");
    // Build query string if needed
    $query = "";
    if (!empty($params)) {
        $query = "?" . http_build_query($params);
    }
    // Final safe URL
    $url = $base . $path . $query;
    header("Location: " . $url);
    exit();
}

?>