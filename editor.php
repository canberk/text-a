<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>TextA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
</head>
<body>
<div class="duvar">
<form method="post" action="index.php">
<textarea type="text"  name="content" style="font-family: Arial;font-size: 12pt;" 
>
<?php
echo $newcontent;
?>
</textarea>
<CENTER>
<input type="password" name="setkey" required>
<input type="submit" name="save_button" value="Kaydet ve Çık">
</form>
<button type="button" onclick="javascript:location.href='/'">Çık</button>
</body>
</html>