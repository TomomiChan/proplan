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
		<title> Proplaner </title>
    	<link rel="stylesheet" href="style.css">
	</head>

	<body>

		<header class="headerunterseiten">
			<div class="lilabannerunterseiten">
				<img class="lesezeichenunterseiten" src="../Images/lesezeichen.png" />
				<img class="gluehbirneunterseiten" src="../Images/gluehbirne.png" width="135px" alt="gluehbirne" />
				<a href = "meineProjekte.php"><img class="proplan" src="../Images/proplan.png" alt="proplan" /> </a>
				<p class="ueberschrift">Impressum</p>	
				<?php
				if($berechtigung == 1){	//anmerkung Christoph: falls der nutzer schon eingelogt ist, darf er folgendes sehen
					echo "<p class=\"pfad\">
						<a href=\"meineProjekte.php\">Meine Projekte ></a>
						Impressum
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
						Impressum
					</p>";
				}
				?>
      	  </div>
			  		
		</header>

		<div class="hauptbereichunterseiten">
			<div class="impressum">
				<h2>Angaben gemäß § 5 TMG:</h2>
				<p>Max Mustermann<br />
				Webdesign Lübeck<br />
				Mönkhoferweg 239<br />
				FH Lübeck<br />
				23562 Lübeck
				</p>
				<h2>Kontakt:</h2>
				
				Telefon:
				0451-00000<br />
				E-Mail: Max-Muster@web.de
				<h2>Copyright</h2><br />
				<h2>Das Copyright für sämtliche Inhalte dieser Website liegt bei Musterfirma, Max Muster.</h2>

				<h2>Disclaimer</h2>

				<p>Alle Texte und Links wurden sorgfältig geprüft und werden laufend aktualisiert. Wir sind bemüht, richtige und vollständige Informationen <br />auf dieser Website bereitzustellen, übernehmen aber keinerlei Verantwortung, Garantien oder Haftung dafür, dass die durch diese Website <br />bereitgestellten Informationen, richtig, vollständig oder aktuell sind. Wir behalten uns das Recht vor, jederzeit und ohne Vorankündigung<br /> die Informationen auf dieser Website zu ändern und verpflichten uns auch nicht, die enthaltenen Informationen zu aktualisieren. <br />Alle Links zu externen Anbietern wurden zum Zeitpunkt ihrer Aufnahme auf ihre Richtigkeit überprüft, dennoch haften wir nicht für <br />Inhalte und Verfügbarkeit von Websites, die mittels Hyperlinks zu erreichen sind. Für illegale, fehlerhafte oder unvollständige Inhalte<br /> und insbesondere für Schäden, die durch Inhalte verknüpfter Seiten entstehen, haftet allein der Anbieter der Seite, auf welche verwiesen<br /> wurde. Dabei ist es gleichgültig, ob der Schaden direkter, indirekter oder finanzieller Natur ist oder ein sonstiger Schaden vorliegt, <br />der sich aus Datenverlust, Nutzungsausfall oder anderen Gründen aller Art ergeben könnte.<br />

				<h2>Datenschutz</h2>

Für die Sicherheit der Datenübertragung im Internet können wir keine Gewähr übernehmen, insbesondere besteht bei der Übertragung <br />von Daten per E-Mail die Gefahr des Zugriffs durch Dritte.

Einer Nutzung der im Impressum veröffentlichten Kontaktdaten durch Dritte<br /> zu Werbezwecken wird hiermit ausdrücklich widersprochen. Der Betreiber behält sich für den Fall unverlangt zugesandter Werbe- oder <br />Informationsmaterialien ausdrücklich rechtliche Schritte vor.

Sollten einzelne Regelungen oder Formulierungen dieses Haftungsaus- <br />schlusses unwirksam sein oder werden, bleiben die übrigen Regelungen in ihrem Inhalt und ihrer Gültigkeit hiervon unberührt.
			</p>
			</div>
		</div>

		<footer>
			<a href="impressum.php">Impressum</a>&nbsp &nbsp &nbsp &nbsp &nbsp <a href="kontakt.html">Kontakt</a>&nbsp &nbsp &nbsp &nbsp &nbsp  <a href="nutzungsbestimmung.php">Nutzungsbestimmung</a>
		</footer>
     </body>
	
</html>
