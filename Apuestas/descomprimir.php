<?php

$filename = "./database.zip";
if (file_exists("./database.zip")) {
    $zip = new ZipArchive;
    if ($zip->open($filename) === TRUE) {
        $zip->extractTo('./');
        $zip->close();
        echo 'ok';
    } else {
        echo 'error';
    }
}