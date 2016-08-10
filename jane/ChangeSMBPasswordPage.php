<?php
include 'vars.php';
include 'verifysession.php';
if ($SessionIsVerified == "1") {
    include 'connect2db.php';
    include 'head.php';

    echo "<div>";
    echo "<form action=\"ChangeSMBPassword.php\" method=\"post\">";
    echo "Change SMB Password<br>";
    echo "<p class=\"tab\">";
    echo "Old SMB Password:<br><input type=\"password\" name=\"OldSMBPassword\" autocomplete=\"off\"><br>";
    echo "New SMB Password:<br><input type=\"password\" name=\"NewSMBPassword\" autocomplete=\"off\"><br>";
    echo "<br>";
    echo "<input type=\"submit\">";
    echo "</form>";
    echo "</div>";
    echo "</body>";
    echo "</html>";
}
?>
