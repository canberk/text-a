<?php

$FILE_NAME = 'file.txt';

$key = $_POST['key'];
$set_key = $_POST['setkey'];

if (empty($key)) {
    include 'form.php';
} else {
    $key = generate_key($key);
    
    if(file_exists($FILE_NAME)){
        $file = fopen($FILE_NAME, 'r');
    }else{
        $file = fopen($FILE_NAME, 'w');
    }

    if(filesize($FILE_NAME) > 0){
        $crypted = fread($file, filesize($FILE_NAME));
        $clear = decrypt($crypted, $key);
    }
    
    include 'editor.php';
}

if (isset($_POST['save_button'])) {
    $content = $_POST["content"];
    $set_key = generate_key($set_key);

    date_default_timezone_set('Europe/Istanbul');
    $file = fopen($FILE_NAME, 'w');
    $date = date("d-m-Y H:i");
    $recordfile = fopen($date, 'w');
    
    $crypted = encrypt($content, $set_key);

    fwrite($file, $crypted);
    fwrite($recordfile, $crypted);
    fclose($file);
    fclose($recordfile);
}

function generate_key($key)
{
    $iterations = 1000;
    $salt = "2SeBDP88w4bqKbJaCJNpNuRHQhUM96X1";
    $newKey = hash_pbkdf2("sha256", $key, $salt, $iterations, 20);
    return $newKey;
}

function encrypt($clear, $key)
{
    $counter = 0;

    for ($i = 1; $i <= strlen($clear); $i++) {
        $letter = substr($clear, $counter, 1);
        $keyletter = substr($key, $counter%20, 1);
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

function decrypt($crypted, $key)
{
    $counter = 0;

    for ($i = 1; $i <= strlen($crypted)/3; $i++) {
        $letter = substr($crypted, $counter*3, 3);
        $keyletter = substr($key, $counter%20, 1);
        $keyletter = ord($keyletter);
        $newletter = $letter - $keyletter;
        $newletter = chr($newletter);
        $clear = $clear .  $newletter;
        $counter++;
    }

    return $clear;
}

//EOF
