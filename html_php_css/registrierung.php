<?php
/**
  * Dieses Dokument beinhaltet das Registrierungsformular
  * Zusätzlich arbeitet dieses Dokument mit registrieren.php zusammen und sorgt für eine richtige Registrierung
  * @author Max Roth
  */
//hole die werte aus dem vorherigen File
session_start();

// Abfrage, ob der Nutzer gerade von der Registrierungsseite kommt
// Das bedeutet, ein Registrierungsversuch ist fehlgeschlagen
if(isset($_SESSION['fromReg']) && $_SESSION['fromReg']) {

	// Zuruecksetzen des boolean, der ueberprueft, ob man von der Registrierungsseite kommt
  unset($_SESSION['fromReg']);

  // Um den value Parameter im HTML Tag mit den bisher richtigen Werten auszufuellen
	$_SESSION['username']= $_SESSION['username'];
	$_SESSION['email']= $_SESSION['email'];

  // Wenn der gewuenschte Benutzername bereits vergeben ist
  if (isset($_SESSION['userExists']) && $_SESSION['userExists']) {

    // Zuruecksetzen des boolean
    unset($_SESSION['userExists']);

    // JavaScript PopUp, was zeigt, dass der benuter bereits vergeben ist
    echo "<script type='text/javascript'>
            alert('Der Username ist bereits vorhanden.')
          </script>";
  }

  // Wenn die Passwoerter nicht uebereinstimmen
  if (isset($_SESSION['passMismatch']) && $_SESSION['passMismatch']) {

    // Zuruecksetzen des boolean
    unset($_SESSION['passMismatch']);

    // JavaScript Pop Up, was zeigt, dass die Passwoerter nicht übereinstimmen
    echo "<script type='text/javascript'>
            alert('Die Passwörter stimmen nicht überein.')
          </script>";
  }

  // Wenn die Passwortsicherheit nicht erfuellt wurde
  if (isset($_SESSION['passUnsafe']) && $_SESSION['passUnsafe']) {

    // Zuruecksetzen des boolean
    unset($_SESSION['passUnsafe']);

    // JavaScript Pop Up, was zeigt, dass die Passwortsicherheit nicht erfuellt wurde
    echo "<script type='text/javascript'>
            alert('Das Passwort muss eine Länge von mindestens 8 Zeichen, eine Zahl und ein Klein- und Großbuchstaben enthalten')
          </script>";
  }

} else {

  // value Parameter fuer das HTML Form Tag (Wenn der User ganz normal auf die Registrierungsseite kommt)
	$_SESSION['username']= "";
	$_SESSION['email']= "";
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
	<title> Proplaner </title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="headerunterseiten">
			<div class="lilabannerunterseiten">
			<img class="lesezeichenunterseiten" src="../Images/lesezeichen.png" />
			<img class="gluehbirneunterseiten" src="../Images/gluehbirne.png" width="135px" alt="gluehbirne" />
			<a href = "meineProjekte.php"><img class="proplan" src="../Images/proplan.png" alt="proplan" /> </a>
			<p class="ueberschrift">Registrierung</p>
			<p class="pfad">
								<a href="index.php">Anmeldung ></a> Registrierung</p>
			</div>
		</header>

    <div class="formularfeld">

      <h3>Erstelle dein proplan Konto</h3>

        <form  name="Form" class="formularinhalt" id="schrift" method="POST" enctype="multipart/form-data" action = "registrieren.php">

            <div id ="kleineSchrift">* benötigtes Feld</div> <br>

            <div class="formularzeile">
                Benutzername *<input type="text" name="username" class="textfeld" required="" value="<?php echo $_SESSION['username'];?>">
            </div>

            <div class="formularzeile">
                 E - Mail *<input type="email" name="email" class="textfeld" required="" value="<?php echo $_SESSION['email'];?>">
            </div>

            <div class="formularzeile">
                Passwort *<input type="password" name="password" class="textfeld" minlength= "8" required="">
            </div>

            <div class="formularzeile">
                Passwort bestätigen *<input type="password" name="confirmpassword" class="textfeld" required="">
            </div>

            <div id="submit">
                <input type="submit" name="button" value="Registrieren" class="button" onclick="return submitForm()"/ required="">
            </div>
			 <div id ="kleineSchrift">Mit der Registrierung stimmen Sie automatisch unseren <a href="nutzungsbestimmung.php">Nutzerbedingungen</a> zu.</div>
        </form>
    </div>
	<footer>
		<a href="impressum.php">Impressum</a>&nbsp &nbsp &nbsp &nbsp &nbsp <a href="kontakt.html">Kontakt</a>&nbsp &nbsp &nbsp &nbsp &nbsp  <a href="nutzungsbestimmung.php">Nutzungsbestimmung</a>
	</footer>
</body>
</html>
