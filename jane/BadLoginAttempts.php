<?php
include 'vars.php';
include 'verifysession.php';
if ($SessionIsVerified == "1") {
    include 'connect2db.php';
    include 'head.php';

    if ($isAdministrator == 1) {

        echo "<div>";
        //Recent bad login attempts.
        echo "<font color=\"red\">Recent bad login attempts:</font><br>";
        $sql = "SELECT `badUsername`,`badREMOTE_ADDR`,`badHTTP_USER_AGENT` FROM `badLoginAttempts` ORDER BY `badREQUEST_TIME` desc LIMIT 40";
        $result = $link->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<br>";
                echo "&emsp;&emsp;" . $row["badUsername"] . "<br>";
                echo "&emsp;&emsp;" . $row["badREMOTE_ADDR"] . "<br>";
                echo "&emsp;&emsp;" . $row["badHTTP_USER_AGENT"] . "<br>";
            }
            $result->free();
        }
        echo "</div>";
        echo "</body>";
        echo "</html";
    }
} else {
    //Not an admin, redirect to home.
    $NextURL="jane.php";
    header("Location: $NextURL");
}
?>

