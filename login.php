<html>
  <title>Jane</title>
  <body>
  <form name="Jane"action="authenticate.php" method="post">
<?php
session_start();
if (isset($_SESSION['badLoginAttempt'])) {
	if ( $_SESSION['badLoginAttempt'] == "1" ) {
		echo $_SESSION['ErrorMessage'] . "<p>";
	}
}
?>
  username<input type="text"name="username">
  <br>password<input type="password" name="password">
  <br>
  <input type="submit"name="submit"value="login">
  </form>
  </body>
</html>

