<?php
include 'vars.php';
include 'verifysession.php';
if ($SessionIsVerified == "1") {
        if ($isAdministrator == 1) {

		$serverStatus="/var/www/html/jane/serverStatus.txt";
		exec("echo \"Server Status\" > $serverStatus");
		exec("echo \" \" >> $serverStatus");
		exec("echo \" \" >> $serverStatus");
		exec("echo \"Partition Usage\" >> $serverStatus");
		exec("df -h >> $serverStatus");
		exec("echo \" \" >> $serverStatus");
		exec("echo \"Memory Usage\" >> $serverStatus");
		exec("free -h >> $serverStatus");
		exec("echo \" \" >> $serverStatus");
		exec("echo \"Uptime\" >> $serverStatus");
		exec("uptime >> $serverStatus");
		exec("echo \" \" >> $serverStatus");
		exec("echo \"Samba Status\" >> $serverStatus");
		exec("systemctl status smb >> $serverStatus");
		exec("echo \" \" >> $serverStatus");
		exec("echo \"Firewall Status\" >> $serverStatus");
		exec("systemctl status firewalld >> $serverStatus");

		include 'head.php';
		echo "<title>Server Status</title>";
		echo "<div>";
		echo "<pre>";
		include "$serverStatus";
		echo "</pre>";
		echo "</div>";
		echo "</body>";
		echo "</html>";

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
