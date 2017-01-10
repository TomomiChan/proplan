<?php
//hole die werte aus dem vorherigen File
session_start();

// Abfrage, ob der Nutzer gerade von der Registrierungsseite kommt
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
            alert('Dein Passwort sollte zwischen 5 und 30 Zeichen lang sein und mind. eine Zahl und Buchstaben enthalten')
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
			<img class="proplan" src="../Images/proplan.png" alt="proplan" />
			<p class="ueberschrift">Registrierung</p>
			</div>
		</header>

    <div class="Formularfeld">

      <h3>Erstelle dein proplan Konto</h3>

        <form  name="Form" class="Formularinhalt" id="schrift" method="POST" enctype="multipart/form-data" action = "registrieren.php">

            <a id ="kleineSchrift">* benötigtes Feld</a> <br><br/>

            <div class="Formularzeile">
                Benutzername *<input type="text" name="username" class="textfeld" required="" value="<?php echo $_SESSION['username'];?>">
            </div>

            <div class="Formularzeile">
                 E - Mail *<input type="email" name="email" class="textfeld" required="" value="<?php echo $_SESSION['email'];?>">
            </div>

            <div class="Formularzeile">
                Passwort *<input type="password" name="password" class="textfeld" minlength= "8" required="">
            </div>

            <div class="Formularzeile">
                Passwort bestätigen *<input type="password" name="confirmpassword" class="textfeld" required="">
            </div>

            <div id="submit" class="Formularzeile">
                <input type="submit" name="button" value="Registrieren" class="button" onclick="return submitForm()"/ required="">
            </div>
        </form>
    </div>
	<footer>
		<a href="impressum.html">Impressum</a>&nbsp &nbsp &nbsp &nbsp &nbsp <a href="kontakt.html">Kontakt</a>&nbsp &nbsp &nbsp &nbsp &nbsp <a href="agb.html">AGB</a>
	</footer>
</body>
</html>
