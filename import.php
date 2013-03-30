<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Instapaper: Export</title>
</head>
<body>
<h1>Unread</h1>
<ol>
<?php
    $file_handle = fopen("new.txt", "r");
    while (!feof($file_handle)) {
        $galbool = FALSE;
        $line = fgets($file_handle);
        $string = $line;
        $check = $string[strlen($string)-2];
        if ( $check == "/"){
            $string = rtrim($string);
            $string = rtrim($string, "/");
            $desc = $string;
        }
        $gallerycheck = str_replace("/gallery", "", $string, $count);
        if ($count == 1){
            $galbool = TRUE;
            $string = rtrim($string);
            $string = rtrim($string, "/gallery");
            $desc = $string;
        }
        $desc = strrchr($string, "/");
        $desc = str_replace("/", "", $desc);
        $desc = str_replace("-", " ", $desc);
        $desc = ucwords($desc);
        if ($galbool == TRUE){
        $formatted = '  		<li><a href="' . $string . '">' . $desc . '[Gallery]</a></li>';
        } else {
        $formatted = '			<li><a href="' . $string . '">' . $desc . '</a></li>';
        }
        echo $formatted;
    }
    fclose($file_handle);
?>
</ol>
</body>
</html>
