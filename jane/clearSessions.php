<?php
include 'vars.php';
include 'verifysession.php';
if ($SessionIsVerified == "1") {
    include 'connect2db.php';
    if ($isAdministrator == 1) {


        $sql = "TRUNCATE TABLE `Sessions`";
        if ($link->query($sql)) {
            // good, send back to jane.php
            $NextURL="jane.php";
            header("Location: $NextURL");
        } else {
            // Error
            $link->close();
            die ($SiteErrorMessage);
        }


    } else {
        //Not an admin, redirect to home.
        $NextURL="jane.php";
        header("Location: $NextURL");
    }
}
?>
