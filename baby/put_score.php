<?php

header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$request = json_decode(file_get_contents('php://input'), true);

// Request shall have the following keys: level_name, name, score, request_uuid, hash.
$level_name = $request["level_name"];
$name = $request["name"];
$score = intval($request["score"]);
$request_uuid = $request["request_uuid"];
$hash = $request["hash"];

if ((strpos($level_name, '"') !== false) || (strpos($name, '"') !== false) || (strpos($request_uuid, '"') !== false)) {
    http_response_code(400);
    echo "Invalid chars in request";
    exit();
}

$secret_key = '11280fe6-3525-4fc6-bb84-7d5b374bb502';

// Check the request hash
$hash_str = $level_name . '"' . $name . '"' . $score . '"' . $request_uuid . '"' . $secret_key;
$correct_hash = sha1($hash_str);

if ($hash !== $correct_hash) {
    http_response_code(400);
    echo "Bad hash";
    exit();
}

// Read file (use flock so we can't get race conditions)
$fp = fopen("./scores.json", "r+");
if (flock($fp, LOCK_EX)) {
    $file = fread($fp, filesize("./scores.json"));
    $json = json_decode($file, true);
    $room = $level_name;

    if (!array_key_exists($room, $json)) {
        flock($fp, LOCK_UN);
        fclose($fp);
        http_response_code(404);
        exit();
    }

    $entry = array(
        "name" => $name,
        "score" => $score,
        "request_uuid" => $request_uuid
    );

    // Look for the UUID
    $index = 0;
    while ($index < count($json[$room])) {
        if ($json[$room][$index]['request_uuid'] === $request_uuid) {
            flock($fp, LOCK_UN);
            fclose($fp);
            http_response_code(400);
            echo "Already seen a request with this ID";
            exit();
        }
        $index += 1;
    }

    $index = 0;
    while (($index < count($json[$room])) && ($json[$room][$index]['score'] > $score)) {
        $index += 1;
    }

    if ($index < count($json[$room])) {
        $json[$room] = array_merge(array_slice($json[$room], 0, $index),
                                   array_merge(array($entry),
                                               array_slice($json[$room], $index, count($json[$room]))));
    } else {
        array_push($json[$room], $entry);
    }

    ftruncate($fp, 0);
    fseek($fp, 0);
    fwrite($fp, json_encode($json));

    flock($fp, LOCK_UN);
    fclose($fp);
    http_response_code(200);
} else {
    http_response_code(500);
}

?>
