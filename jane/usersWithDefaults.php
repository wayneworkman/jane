<?php
include 'vars.php';
include 'verifysession.php';
if ($SessionIsVerified == "1") {
	if ($isAdministrator == 1) {
		include 'connect2db.php';
		include 'head.php';

		echo "<title>Users With Defaults</title>\n";
		echo "<div>\n";
		echo "Users with default passwords\n<br><br><br>\n";


		$sql = "SELECT `JaneUsername`,`JaneSMBPassword`,`JanePassword` FROM `janeUsers`";
		$result = $link->query($sql);
		if ($result->num_rows > 0) {
		echo "<table>\n";
		echo "<tr>\n";
		echo "<th>Username</th>\n";
		echo "<th>Jane password is default?</th>\n";
		echo "<th>SMB Passowrd is default?</th>\n";
		echo "</tr>\n";
			while($row = $result->fetch_assoc()) {
				$user = trim($row["JaneUsername"]);
				$SMBPass = trim($row["JaneSMBPassword"]);
				$userPass = trim($row["JanePassword"]);


				if ((password_verify($PasswordDefault, $userPass)) || ($SMBPass == $PasswordDefault)) {

					echo "<td>$user</td>\n";

					if (password_verify($PasswordDefault, $userPass)) {
						echo "<td><font color=\"red\">Yes</font></td>\n";
					} else {
						echo "<td><font color=\"green\">No</font></td>\n";
					}
					if ($SMBPass == $PasswordDefault) {
                                                echo "<td><font color=\"red\">Yes</font></td>\n";
                                        } else {
                                                echo "<td><font color=\"green\">No</font></td>\n";
                                        }

					echo "</tr>\n";

				}
			}
		echo "</table>\n";
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
