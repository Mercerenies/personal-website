<?php

function base64_url_encode($input) {
    return strtr(base64_encode($input), '+/=', '._-');
}

function base64_url_decode($input) {
    return base64_decode(strtr($input, '._-', '+/='));
}

# Validate request method.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("HTTP/1.1 405 Method Not Allowed");
    header("Allow: POST");
    header("Content-Type: text/plain");
    echo("Invalid HTTP request");
    exit;
}

# Validate that the fields expected of the body are there.
if ((!array_key_exists('targetname', $_POST)) ||
    (!array_key_exists('signature', $_POST)) ||
    (!array_key_exists('data', $_POST))) {
    header("HTTP/1.1 400 Bad Request");
    header("Content-Type: text/plain");
    echo("Missing parameter(s).");
    exit;
}

$signature = base64_url_decode($_POST['signature']);
$data = base64_url_decode($_POST['data']);
$targetname = $_POST['targetname'];

# Validate target name format.
if (preg_match("/^[A-Za-z0-9-]+$/", $targetname) !== 1) {
    header("HTTP/1.1 400 Bad Request");
    header("Content-Type: text/plain");
    echo("Bad targetname");
    exit;
}

# Validate that the target name is not in use.
if (file_exists($targetname.".html")) {
    header("HTTP/1.1 400 Bad Request");
    header("Content-Type: text/plain");
    echo("Resource already exists.");
    exit;
}

# Check the signature against all of our known public keys.
$valid = false;
$dir = new DirectoryIterator("./keys");
foreach ($dir as $fileinfo) {
    if (!$fileinfo->isDot()) {
        if ($fileinfo->getExtension() === "pem") {
            $pubkey = file_get_contents($fileinfo->getPathname());
            $result = openssl_verify($data, $signature, $pubkey, "sha256WithRSAEncryption");
            if ($result === 1) {
                $valid = true;
                break;
            }
        }
    }
}

if ($valid) {
    file_put_contents($targetname.".html", $data);
    header("HTTP/1.1 200 OK");
    header("Content-Type: text/plain");
    echo("Success.\n");
    echo("/".$targetname.".html");
} else {
    header("HTTP/1.1 400 Bad Request");
    header("Content-Type: text/plain");
    echo("Bad file signature.");
}
