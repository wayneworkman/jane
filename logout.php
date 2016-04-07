<?php
include 'vars.php';
include 'verifysession.php';
if ($SessionIsVerified == "1") {
                include 'connect2db.php';

                $sql = "DELETE FROM `Sessions` WHERE `fingerprint` = '$fingerprint'";


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
        $NextURL="login.php";
        header("Location: $NextURL");
}
?>
