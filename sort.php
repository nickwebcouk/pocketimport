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
 
// First off, we start by opening the file required (starred.json),
// Then we set the $galbool paramater (This is used where sites have
// given a "Gallery" URL (To make it more cosmetic, it appends the
// text [Gallery] to the end of the description.
 
$file_handle = fopen("starred.json", "r");
while (!feof($file_handle)) {
    $galbool = FALSE;
    $line = fgets($file_handle);
 
// This is our first check. We run through the json file and look for
// lines that contain the text "href". If it does not have that text,
// we are not interested, and set that line to be blank.

    $preg = "(\"href\")";
    $urlcheck = preg_match($preg, $line);
    if ($urlcheck !== 1) {
    $line = "";
    } else {

// A cheeky little bit of coding. Whislt we are in the loop, and
// I know that this is a URL we are intersted in, I'll have a look
// at the last character. If its a ",", I also want to delete that
// line. Looking at the JSON file, if a line contains a URL and
// ends with a ",", it means its not the *ACTUAL* URL we want, so
// we continue our ruthless streak and set that line to blank!
// (This was included ot deal with hackaday.com URL's, which for
// some reason doubled up, and this was a quick and easy way to
// get rid of them!

        $preg = "(,)";
        $clean = preg_match($preg, $line);
        if ($clean !== 0) {
            $line = "";
        }
        }

// Now we trim the whitespace and other non-needed characters, and
// we remove the first bit from the string thats not needed. This
// takes us right to the http:// part of the link, which is what we
// need! We also remove the trailing slash from the link as well.

        trim($line);
        $line = substr($line, 16);
        $line = substr_replace($line, "", -2);
        $string = $line;
 
        $check = $string[strlen($string)-2];
        if ( $check == "/"){
            $string = rtrim($string);
            $string = rtrim($string, "/");
            $desc = $string;
        }
        $check = $string[strlen($string)-1];
        if ( $check == "/"){
            $string = rtrim($string);
            $string = rtrim($string, "/");
            $desc = $string;
        }

// This is just a quick check to see if the URL passed is a gallery
// URL. If so, we set the $galbool value to true, and then do our
// usual URL cleanup. I have removed the /gallery part from the URL
// This is personal preferance, and I've not had any adverse effects
// from either taking it in, or removing it. It has to be removed
// just now to make figuring out the link text easier though.
// We can add it back in later if required.

        $gallerycheck = str_replace("/gallery", "", $string, $count);
        if ($count == 1){
            $galbool = TRUE;
            $string = rtrim($string);
            $string = rtrim($string, "/gallery");
            $desc = $string;
        }

// And now for the (almost) finale! We take everything after the
// forward slash in the URL, remove that forward slash, then we
// run through and replace every "-" with a space. This makes the
// end HTML page look nice, and it keeps with Instapapers Export
// option. If the $galbool value is true, we create a [Gallery]
// tag.

        $desc = strrchr($string, "/");
        $desc = str_replace("/", "", $desc);
        $desc = str_replace("-", " ", $desc);
        $desc = ucwords($desc);
        if ($string != "" ){
        if ($galbool == TRUE){

// you can add back in the /gallery link here again if you need it!
// Just uncomment the relevant line and comment out the other!
//        -------------------------------------------------------------------------------------------------

//        $formatted = '            <li><a href="' . $string . '/gallery">' . $desc . '[Gallery]</a></li>';

//        ----------------------------------***OR THIS LINE***---------------------------------------------

        $formatted = '            <li><a href="' . $string . '">' . $desc . '[Gallery]</a></li>';

//        -------------------------------------------------------------------------------------------------

        } else {
        $formatted = '            <li><a href="' . $string . '">' . $desc . '</a></li>';
        }
        echo $formatted;
        }
    }

// We now close the file (good housekeeping), and finish up
// the script.

fclose($file_handle);
?>
</ol>
</body>
</html>
