<?php
include 'vars.php';
include 'verifysession.php';
if ($SessionIsVerified == "1") {
        if ($isAdministrator == 1) {

		//define file.
		$JaneEngineLog = "/jane/log/JaneEngine.log";


		//build page.
		include 'head.php';
		echo "<title>Jane Engine Log</title>\n";
		echo "<div>\n";
		echo "<pre>\n";
		echo file_get_contents($JaneEngineLog);
		echo "</pre>\n";
		echo "</div>\n";
		echo "</body>\n";
		echo "</html>\n";


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
