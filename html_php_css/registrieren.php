<?php
	  //hole die werte aus dem Formular
  	session_start();

    // Values aus dem Formular holen
	  $_SESSION['username']= $_POST['username'];
    $_SESSION['email']= $_POST['email'];
    $_SESSION['password']= $_POST['password'];

    $confirmpassword= $_POST['confirmpassword'];

    // Entferne die Quotes
	  $username = stripcslashes($_SESSION['username']);
    $email = stripcslashes($_SESSION['email']);
	  $password = stripcslashes($_SESSION['password']);
    $confirmpassword = stripcslashes($confirmpassword);

    // Entferne special Charakters
	  $username = mysql_real_escape_string($username);
    $email = mysql_real_escape_string($email);
	  $password = mysql_real_escape_string($password);
    $confirmpassword = mysql_real_escape_string($confirmpassword);

    // Bei einer erfolgreichen Registrierung, wird der Nutzer direkt auf die Login Seite weitergeleitet
    $_SESSION['fromReg'] = true;

    $_SESSION['userExists'] = false;

    $_SESSION['passMismatch'] = false;

    // MD5 Verschlüsselung des Passworts
	  $passwordfinal = md5($passwort);

    // Variable für die Datenbank
    $dbname = "pro_db";
    // Herstellung der Verbindung zur Datenbank
    $conn = new mysqli("localhost", "root", "", $dbname);

    // Ueberpruefung der Verbindung
    if ($conn->connect_error) {
        die("Verbindung zur Datenbank ist fehlgeschlagen ".$conn->connect_error);
    }
    // Herstellung der Verbindung zur Datenbank
    $connfinal = new mysqli("localhost", "root", "", $dbname);

    // Ueberpruefung der Verbindung
    if ($connfinal->connect_error) {
        die("Verbindung zur Datenbank ist fehlgeschlagen ".$connfinal->connect_error);
    }

    // Ueberpruefen, ob der user schon vorhanden ist
    $check = $conn->query ("SELECT * FROM user WHERE name = '$username'");

    if (mysqli_num_rows($check) != 0) {

      $_SESSION['userExists'] = true;

      header("location:registrierung.php");

      // Wenn die Passwortbestaetigung fehlerhaft ist
    } else if (strcmp($password, $confirmpassword) !== 0) {

      $_SESSION['passMismatch'] = true;

      header("location:registrierung.php");

    } else {

      // Datenbankeintrag eines neuen Users
      $result = $connfinal->query("INSERT INTO user(email, passwort, name) VALUES ('$email','$passwordfinal','$username')");

      header("location:index.php");
    }
?>
