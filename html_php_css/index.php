<?php
/**
*Stellt die Startseite dar, in der sich der Nutzer einloggen kann oder weiter zur Registrierungsseite gelangt
*uebergibt login.php die eingegebenen Werte des Login
*@author Alice Markmann
*@author Max Roth - MR
**/

session_start();

// Abfrage, ob der Nutzer von der Registrierungsseite weitergeleitet wurde (Bedeutet er hat sich gerade neu registriert)
// Wenn dies der Fall ist, wird der Nutzer benachrichtigt, dass er sich jetzt einloggen kann - MR
if(isset($_SESSION['fromReg']) && $_SESSION['fromReg']) {

// Zuruecksetzen des boolean, welcher ueberpruef, ob man durch einen Redirect auf die index Seite gekommen ist
  unset($_SESSION['fromReg']);

// JavaScript Pop Up, welches zeigt, dass sich der Nutzer jetzt einloggen kann
  echo "<script type='text/javascript'>
          alert('Die Registrierung war erfolgreich. Du kannst dich nun einloggen.')
        </script>";
}

?>

 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta charset="utf-8">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
	<title> Proplaner </title>
    <link rel="stylesheet" href="style.css">

</head>

<body>

<header>
	<div id="lilabereich">
		<section>
			<img id="grafikoben" src="../Images/obengrafik.png">
		</section>
    </div>
</header>

<div id="hauptbereich">
	<section>
		<img id="lesezeichen" src="../Images/lesezeichen.png">
    </section>

	<h1> Organisiere dich jetzt!</h1>

		<img id="wasgibtes" src="../Images/wasgibtes.png">

		<img id="klemmbrett" src="../Images/klemmbrett.png">



	<form id="formular" method="POST" action="login.php">
		<table>
			<tr>
				<td id="username">
					<input type="email" placeholder="Email" name="email" required>
				</td>
			</tr>
			<tr>
				<td id="passwort">
					<input type="password" placeholder="Passwort" name="psw" required>
				</td>
			</tr>
			<tr>
				<td id="login">
					<button type="submit" id="button1" value="Login">Login</button>
				</td>
			</tr>
			</table>

		</form>
		<form id="formular1" action="registrierung.php">

		<table>
			<tr>
				<td id="registrieren">
					<button type="submit" id="button2" value="Registrieren">Registrieren</button>
				</td>
			</tr>
		</table>

		</form>


	<p id="registriert">
		Noch nicht angemeldet?
	</p>

</div>



</body>
</html>
