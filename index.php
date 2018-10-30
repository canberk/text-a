<?php

$key = $_POST["key"];
$setkey = $_POST["setkey"];

if (empty($key)) {
    include "form.php";
} else {
    $key = refreshKey($key);

    $file = fopen('file.txt', 'r+');
    $crypted = fread($file, filesize('file.txt'));
    
    $clear = decrypt($crypted);

    include "editor.php";
}

if (isset($_POST['save_button'])) {
    $content = $_POST["content"];
    $setkey = refreshKey($setkey);

    date_default_timezone_set('Europe/Istanbul');
    $file = fopen('file.txt', 'w');
    $date = date("d-m-Y H:i");
    $recordfile = fopen($date, 'x');
    
    $crypted = encrypt($content);

    fwrite($file, $crypted);
    fwrite($recordfile, $crypted);
    fclose($file);
    fclose($recordfile);
}

function refreshKey($key)
{
    $newKey = hash('md5', $key);
    return $newKey;
}

function encrypt($clear){
    $counter = 0;
    for ($i = 1; $i <= strlen($clear); $i++) {
        $letter = substr($clear, $counter, 1);
        $keyletter = substr($setkey, $counter%32, 1);
        $letter = ord($letter);
        $keyletter = ord($keyletter);
        $newletter = $letter + $keyletter;
        while (strlen($newletter) < 3) {
            $newletter = ' ' . $newletter;
        }
        $crypted = $crypted .  $newletter;
        $counter++;
    }
    return $crypted;
}

function decrypt($crypted){
    $counter = 0;
    for ($i = 1; $i <= strlen($crypted)/3; $i++) {
        $letter = substr($crypted, $counter*3, 3);
        $keyletter = substr($key, $counter%32, 1);
        $keyletter = ord($keyletter);
        $newletter = $letter - $keyletter;
        $newletter = chr($newletter);
        $clear = $clear .  $newletter;
        $counter++;
    }
    return $clear;
}
