<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head></head>
<body>
<form action="" method="post">
  <h1>Éttermi asztalfoglalás</h1><br>
  <label for="email">Email cím:</label>
  <input type="text" id="email" name="email">
    <input type="submit" value="Belépés">
</form>
</body>
</html>
<?php
if (isset($_POST["email"]))
{
    $_SESSION["email"]=$_POST["email"];
    header('Location: mainpage.php');
}


