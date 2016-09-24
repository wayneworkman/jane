<?php
include 'vars.php';
include 'verifysession.php';
if ($SessionIsVerified == "1") {
        if ($isAdministrator == 1) {

		//define file.
		$serverStatus="/jane/apacheTemp/serverStatus.txt";

		//clean file, echo first line and following command outputs.
		exec("echo \" \" > $serverStatus");
		exec("echo \"-----------------------------------Jane Engine running?\" >> $serverStatus");
		exec("echo \" \" >> $serverStatus");
		exec("ps -aux | grep \"[J]ane\" >> $serverStatus");
		exec("echo \" \" >> $serverStatus");
		exec("echo \"-----------------------------------Partition Usage\" >> $serverStatus");
		exec("echo \" \" >> $serverStatus");
		exec("df -h >> $serverStatus");
		exec("echo \" \" >> $serverStatus");
		exec("echo \"-----------------------------------Memory Usage\" >> $serverStatus");
		exec("echo \" \" >> $serverStatus");
		exec("free -h >> $serverStatus");
		exec("echo \" \" >> $serverStatus");
		exec("echo \"-----------------------------------Uptime\" >> $serverStatus");
		exec("echo \" \" >> $serverStatus");
		exec("uptime >> $serverStatus");
		exec("echo \" \" >> $serverStatus");
		exec("echo \"-----------------------------------Samba Status\" >> $serverStatus");
		exec("echo \" \" >> $serverStatus");
		exec("systemctl status smb -l >> $serverStatus");
		exec("echo \" \" >> $serverStatus");
		exec("echo \"-----------------------------------Firewall Status\" >> $serverStatus");
		exec("echo \" \" >> $serverStatus");
		exec("systemctl status firewalld -l >> $serverStatus");

		//build page, include the command outputs.
		include 'head.php';
		echo "<title>Server Status</title>";
		echo "<div>";
		echo "<pre>";
		echo file_get_contents($serverStatus);
		echo "</pre>";
		echo "</div>";
		echo "</body>";
		echo "</html>";

		//blank out file when done.
		exec("echo \" \" > $serverStatus");

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
