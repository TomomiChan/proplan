<?php
//hole die werte aus dem vorherigen File
// für den Fall, dass man nach der Registrierung direkt zur Login Seite gefuehrt wird
session_start();

// Abfrage, ob der Nutzer gerade von der Registrierungsseite kommt
// Wenn dies der Fall ist, wird der Nutzer benachrichtigt, dass er sich jetzt einloggen kann
if(isset($_SESSION['fromReg']) && $_SESSION['fromReg']) {

  // Zuruecksetzen des boolean, welcher checkt, ob man durch einen Redirect auf die index Seite gekommen ist
  unset($_SESSION['fromReg']);

  // JavaScript Pop Up, was zeigt, dass sich der Nutzer jetzt einloggen kann
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
		<form id="formular1" action="registrierung.php">		<!--hier eigentlich script !-->

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
