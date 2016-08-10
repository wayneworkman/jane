<?php
include 'vars.php';
include 'verifysession.php';
if ($SessionIsVerified == "1") {
    include 'connect2db.php';
    include 'head.php';
    echo "<title>Change Jane Password</title>";
    echo "<div>";
    echo "<form action=\"ChangeJanePassword.php\" method=\"post\">";
    echo "Change Jane Password<br>";
    echo "<p class=\"tab\">";
    echo "Old Jane Password:<br><input type=\"password\" name=\"OldJanePassword\" autocomplete=\"off\"><br>";
    echo "New Jane Password:<br><input type=\"password\" name=\"NewJanePassword\" autocomplete=\"off\"><br>";
    echo "<br>";
    echo "<input type=\"submit\">";
    echo "</form>";
    echo "</div>";
    echo "</body>";
    echo "</html>";
}
?>
