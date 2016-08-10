<?php

echo "<!DOCTYPE html>";
echo "<html>";
echo "<head>";

echo "<style>";
echo "ul {";
echo "    list-style-type: none;";
echo "    margin: 0;";
echo "    padding: 0;";
echo "    overflow: hidden;";
echo "    background-color: #333;";
echo "}";

echo "li {";
echo "    float: left;";
echo "}";

echo "li a, .dropbtn {";
echo "    display: inline-block;";
echo "    color: white;";
echo "    text-align: center;";
echo "    padding: 14px 16px;";
echo "    text-decoration: none;";
echo "}";

echo "li a:hover, .dropdown:hover .dropbtn {";
echo "    background-color: red;";
echo "}";

echo "li.dropdown {";
echo "    display: inline-block;";
echo "}";

echo ".dropdown-content {";
echo "    display: none;";
echo "    position: absolute;";
echo "    background-color: #f9f9f9;";
echo "    min-width: 160px;";
echo "    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);";
echo "}";

echo ".dropdown-content a {";
echo "    color: black;";
echo "    padding: 12px 16px;";
echo "    text-decoration: none;";
echo "    display: block;";
echo "    text-align: left;";
echo "}";

echo ".dropdown-content a:hover {background-color: #f1f1f1}";

echo ".dropdown:hover .dropdown-content {";
echo "    display: block;";
echo "}";
echo "div{padding:10px;border:5px solid gray;margin:0}";
echo "<!--";
echo ".tab { margin-left: 40px; }";
echo "-->";
echo "</style>";
echo "</head>";
echo "<body>";


echo "<ul>";
echo "  <li><a class=\"active\" href=\"jane.php\">Home</a></li>";
echo "  <li class=\"dropdown\">";
echo "    <a href=\"#\" class=\"dropbtn\">Account Options</a>";
echo "    <div class=\"dropdown-content\">";
echo "      <a href=\"ChangeUsernamePage.php\">Change Username</a>";
echo "      <a href=\"ChangeJanePasswordPage.php\">Change Jane Password</a>";
echo "      <a href=\"ChangeSMBPasswordPage.php\">Change SMB Password</a>";
echo "    </div>";
echo "  </li>";
if ($isAdministrator == 1) {
	echo "    <li class=\"dropdown\">";
	echo "    <a href=\"#\" class=\"dropbtn\">Administrator Actions</a>";
	echo "    <div class=\"dropdown-content\">";
	echo "      <a href=\"NewSettingsPage.php\">New Settings</a>";
	echo "      <a href=\"AdminActionPage.php\">User, Group, and IP Management</a>";
	echo "      <a href=\"ListGroups.php\">List Groups</a>";
        echo "      <a href=\"ListUsers.php\">List Users</a>";
        echo "      <a href=\"BlockedIPs.php\">List Blocked IPs</a>";
        echo "      <a href=\"BadLoginAttempts.php\">Bad Login Attempts</a>";
	echo "    </div>";
        echo "   </li>";
}
echo "  <li><a href=\"ListAbnormalUsers.php\">Abnormal Users</a></li>";
echo "  <li><a href=\"DownloadKey.php\">Jane Public Key</a></li>";
echo "  <li><a href=\"showLicense.php\">License</a></li>";
echo "  <li><a href=\"logout.php\">Log Out</a></li>";
echo "  </li>";
echo "</ul>";

?>
