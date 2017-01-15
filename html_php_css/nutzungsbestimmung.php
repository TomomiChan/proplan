<?php
	session_start();
	$berechtigung = 0;
	if(!isset($_SESSION['name']) OR !isset($_SESSION['id'])){
		$berechtigung = 0;
	} else {
		$berechtigung = 1;
	}
?>
<html>
	<head>
		<meta charset="utf-8">
    	<link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
		<title> Proplaner - Nutzungsbestimmung</title>
    	<link rel="stylesheet" href="style.css">
	</head>

	<body>

		<header class="headerunterseiten">
			<div class="lilabannerunterseiten">
				<img class="lesezeichenunterseiten" src="../Images/lesezeichen.png" />
				<img class="gluehbirneunterseiten" src="../Images/gluehbirne.png" width="135px" alt="gluehbirne" />
				<a href = "meineProjekte.php"><img class="proplan" src="../Images/proplan.png" alt="proplan" /> </a>
				<p class="ueberschrift">Nutzungsbestimmung</p>	
				<?php
				if($berechtigung == 1){	//anmerkung Christoph: falls der nutzer schon eingelogt ist, darf er folgendes sehen
					echo "<p class=\"pfad\">
						<a href=\"meineProjekte.php\">Meine Projekte ></a>
						Nutzungsbestimmung
					</p>
					<div class=\"logout\">	
						<a href=\"logout.php\" > <img src=\"../Images/logout.png\" alt=\"logout\" /></a>
					</div>
  
					<div class=\"profil\">
						<a href=\"profil.php\"><img src=\"../Images/profil_weiß.png\" alt=\"profil\" /></a>
					</div>";
				}else {		//wenn nicht dann das:
					echo "<p class=\"pfad\">
						<a href=\"registrierung.php\">Registrierung ></a>
						Nutzungsbestimmungen
					</p>";
				}
				?>
      	  </div>
			  		
		</header>

		<div class="hauptbereichunterseiten">
			<div class="impressum">
				<h2>I. Allgemeines</h2>
				<p>Proplaner ist ein privat betriebener Dienst. Die Nutzung von Proplaner ist für registrierte Benutzer kostenfrei.
				</p>
				<h2>I.I. Aktive Teilnahme auf der Website Proplaner</h2>

				<p>Für die aktive Teilnahme auf der Website ist ein Benutzerkonto, sowie die Zustimmung zu diesen Nutzungsbestimmungen erforderlich. Nach einer Änderung dieser Nutzungsbestimmungen ist eine erneute Zustimmung zu selbigen erforderlich. Ein Ablehnen der Bestimmungen führt zur Löschung des Benutzerkontos.</p>
			
				<h2>II. Registrierung</h2>
				<p>Die Registrierung auf der Website Proplaner ist nur echten Personen gestattet. Jede Person darf maximal ein Benutzerkonto auf der Website besitzen. Ein Recht darauf gibt es nicht. Die Betreiber vom Proplaner behalten sich vor, angelegte Benutzerkonten temporär oder dauerhaft stillzulegen („zu sperren“).</p>
			
				<h2>II. I. Löschung des Benutzerkontos</h2>
				<p>Die Löschung des eigenen Benutzerkontos kann nur über Email an die Betreiber der Website erfolgen. Hierbei muss die Email des zu löschenden Benutzerkontos mit der Email des Antragsteller überinstimmen. Die endgültige Löschung des Benutzerkontos erfolgt dann innerhalb von 7 Tagen.

					Von der Löschung ausdrücklich ausgeschlossen sind erstellte Beiträge und Themen im Forum sowie sonstige eingestellte Inhalte des Benutzers. Die gesetzlichen Ansprüche auf Löschung beziehungsweise Unkenntlichmachung gegebenenfalls enthaltener personenbezogener Daten bleiben davon unberührt.</p>
			
				<h2>II. II. Datenschutzerklärung</h2>
				<p>Der Benutzer stimmt mit der Registrierung der, im Impressum genannten, Datenschutzerklärung zu.</p>
				
				<h2>III. Inhalte</h2>
				<p>Der Benutzer räumt den Betreibern von Proplaner ausdrücklich ein dauerhaftes Nutzungsrecht an den von ihm auf die Website eingestellten Inhalten (zum Beispiel Beiträgen) ein.

					Mit der erfolgreichen Registrierung und Akzeptanz dieser Bedingungen und Bestimmungen erklärt der Benutzer, dass er weder beleidigende, rassistische, kriminelle, menschenverachtende, noch sittenwidrige Inhalte publiziert oder geltendes Recht verletzt.</p>
			
				<h2>III. II. Werbung</h2>
				<p>Soweit durch die Beitreiber von Proplaner in anderen Regelwerken nicht anderes bestimmt ist, ist Werbung auf der Website Proplaner nicht gestattet. Unter Werbung verstehen wir, hauptsächlich einen Werbezweck erfüllende Hinweise und Verweise (so genannte „Hyperlinks“) auf nicht von Proplaner betriebene Webauftritte.</p>
			
				<div id="kleineSchrift">(Letzte Änderung: 16. Januar 2017, 00:03)</div>
			</div>
		</div>

		<footer>
			<a href="impressum.php">Impressum</a>&nbsp &nbsp &nbsp &nbsp &nbsp <a href="kontakt.html">Kontakt</a>&nbsp &nbsp &nbsp &nbsp &nbsp  <a href="nutzungsbestimmung.php">Nutzungsbestimmung</a>
		</footer>
     </body>
	
</html>