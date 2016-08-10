<?php
include 'vars.php';
include 'verifysession.php';
if ($SessionIsVerified == "1") {
    include 'connect2db.php';
    include 'head.php';

    //echo "<div>";
    //echo "<pre>";
    include 'LICENSE';
    //echo "</pre>";
    //echo "</div>";
    echo "</body>";
    echo "</html>";
}
?>

