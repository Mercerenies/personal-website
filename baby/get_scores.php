<?php

header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$room = $_GET["room"];

// Read file (using flock so we can't get race conditions)
$fp = fopen("./scores.json", "r");
if (flock($fp, LOCK_EX)) {
    $file = fread($fp, filesize("./scores.json"));
    flock($fp, LOCK_UN);
    fclose($fp);

    $json = json_decode($file, true);

    if (array_key_exists($room, $json)) {
        echo json_encode($json[$room]);
    } else {
        http_response_code(404);
    }
} else {
    http_response_code(500);
}

?>
