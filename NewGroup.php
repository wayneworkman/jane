<?php
include 'vars.php';
include 'verifysession.php';
if ($SessionIsVerified == "1") {
        if ($isAdministrator == 1) {
                include 'connect2db.php';


                // Do actions here.
                $NewGroupname = $link->real_escape_string(trim($_REQUEST['NewGroupname']));

                $sql = "INSERT INTO janeGroups (JaneGroupName) VALUES ('$NewGroupname')";


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
                // not an admin, redirect to jane.php
                $NextURL="jane.php";
                header("Location: $NextURL");
        }
} else {
        $NextURL="login.php";
        header("Location: $NextURL");
}
?>
