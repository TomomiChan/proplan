<?php
/**
  * Dieses Dokument registriert neue Nutzer und legt entsprechende Eintraege in der Datenbank an
  * Dieses Dokument arbeitet mit der Datei registrierung.php zusammen um die Sicherheit zu gewährleisten
  * Zur Sicherheit gehoert hierbei besipielsweise die Ueberpruefung des Passworts auf Vorgaben
  * @author Max Roth
  */
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

  /* // Entferne die Quotes
	  $username = stripcslashes($_SESSION['username']);
    $email = stripcslashes($_SESSION['email']);
	  $password = stripcslashes($_SESSION['password']);
    $confirmpassword = stripcslashes($confirmpassword);

    // Entferne special Charakters
	  $username = mysql_real_escape_string($username);
    $email = mysql_real_escape_string($email);
	  $password = mysql_real_escape_string($password);
    $confirmpassword = mysql_real_escape_string($confirmpassword); */

    // Boolean ist true, wenn die Registrierung erfolgreich war
    $_SESSION['fromReg'] = true;
    // Boolean ist true, wenn ein Benutzername bereits vergeben ist
    $_SESSION['userExists'] = false;
    // Boolean ist true, wenn Passwort bestaetigen falsch war
    $_SESSION['passMismatch'] = false;
    // Boolean ist true, wenn das Passwort nicht die Sicherheitsanforderung erfuellt
    $_SESSION['passUnsafe'] = false;

    // MD5 Verschlüsselung des Passworts
	  $passwordfinal = md5($password);

		include ("datenbankschnittstelle.php");
		datenbankaufbau();

    // Ueberpruefen, ob der user schon vorhanden ist
    $check = getORSetEintraegeSchleifen("SELECT * FROM user WHERE email = '$email'");

    // Wird ein Eintrag gefunden, ist der Nutzername bereits vorhanden
    if (mysqli_num_rows($check) != 0) {

      $_SESSION['userExists'] = true;

      // Reload des Registrierungsformulars
      header("location:registrierung.php");

      // Wenn die Passwortbestaetigung fehlerhaft ist
    } else if (strcmp($password, $confirmpassword) !== 0) {

      $_SESSION['passMismatch'] = true;

      // Reload des Registrierungsformulars
      header("location:registrierung.php");

      // Ueberpruefe die Passwortsicherheit
      // Das Password darf nicht laenger als 30 und nicht kuerzer als 5 Zeichen sein. Es muss mindestens eine Zahl und ein Buchstabe enthalten sein
    } else if ((strlen($password) < 8) || (strlen($pwd) > 30) || (!preg_match("#[0-9]+#", $password))
    || (!preg_match("#[a-z]+#", $password))||(!preg_match("#[A-Z]+#", $password))) {

      $_SESSION['passUnsafe'] = true;

      // Reload des Registrierungsformulars
      header("location:registrierung.php");

    } else {

      // Wenn alles in Ordnung ist
      // Datenbankeintrag eines neuen Users
      $result = getORSetEintraegeSchleifen("INSERT INTO user(email, passwort, name) VALUES ('$email','$passwordfinal','$username')");

      // Weiterleitung auf die Startseite zum login
      header("location:index.php");
    }

    /** In der ersten Fassung des Registrierungsformulars gab es noch zusätzlich die Möglichkeit ein Profilbild hochzuladen
    * Diese Funktion wurde hier jedoch später rausgenommen, da es kleine Überschneidungsprobleme gab.
    * Nun ist diese Funktion in upload.php zu finden. Die Registrierung ist damit auch für neue Nutzer agenehmer und schneller geworden.
    * Da man bei der Registrierung direkt zum Punkt kommt und essentielle Dinge wie Bild Upload später erledigen kann.
    *
    */
?>
