<?php
	  //hole die werte aus dem Formular
  	session_start();

    // Values aus dem Formular holen
	  $_SESSION['username']= $_POST['username'];
    $_SESSION['email']= $_POST['email'];
    $_SESSION['password']= $_POST['password'];

    $confirmpassword= $_POST['confirmpassword'];

    $username = $_SESSION['username'];
    $email = $_SESSION['email'];
	  $password = $_SESSION['password'];

  /*  // Entferne die Quotes
	  $username = stripcslashes($_SESSION['username']);
    $email = stripcslashes($_SESSION['email']);
	  $password = stripcslashes($_SESSION['password']);
    $confirmpassword = stripcslashes($confirmpassword);

    // Entferne special Charakters
	  $username = mysql_real_escape_string($username);
    $email = mysql_real_escape_string($email);
	  $password = mysql_real_escape_string($password);
    $confirmpassword = mysql_real_escape_string($confirmpassword);*/

    // Bei einer erfolgreichen Registrierung, wird der Nutzer direkt auf die Login Seite weitergeleitet
    $_SESSION['fromReg'] = true;

    $_SESSION['userExists'] = false;

    $_SESSION['passMismatch'] = false;

    $_SESSION['passUnsafe'] = false;

    // MD5 Verschlüsselung des Passworts
	  $passwordfinal = md5($password);

		include ("datenbankschnittstelle.php");
		datenbankaufbau();

    // Ueberpruefen, ob der user schon vorhanden ist
    $check = getORSetEintraegeSchleifen("SELECT * FROM user WHERE email = '$email'");

    if (mysqli_num_rows($check) != 0) {

      $_SESSION['userExists'] = true;

      header("location:registrierung.php");

      // Wenn die Passwortbestaetigung fehlerhaft ist
    } else if (strcmp($password, $confirmpassword) !== 0) {

      $_SESSION['passMismatch'] = true;

      header("location:registrierung.php");

      // Ueberpruefe die Passwortsicherheit
      // Das Password darf nicht laenger als 30 und nicht kuerzer als 5 Zeichen sein. Es muss mindestens eine Zahl und ein Buchstabe enthalten sein
    } else if ((strlen($password) < 5) || (strlen($pwd) > 30) || (!preg_match("#[0-9]+#", $password))
    || (!preg_match("#[a-z]+#", $password))||(!preg_match("#[A-Z]+#", $password))) {

      $_SESSION['passUnsafe'] = true;

      header("location:registrierung.php");

    } else {

      // Datenbankeintrag eines neuen Users
      $result = getORSetEintraegeSchleifen("INSERT INTO user(email, passwort, name) VALUES ('$email','$passwordfinal','$username')");

      header("location:index.php");
    }
?>
