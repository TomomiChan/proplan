<?php
session_start();
	$berechtigung = 0;
	if(!isset($_SESSION['name']) OR !isset($_SESSION['id'])){
		$berechtigung = 0;
		header("location:index.php");
	} else {
		$berechtigung = 1;
		$benutzer = $_SESSION['name'];
		$benutzer_id = $_SESSION['id'];
		
		//Verbinung zu Datenbank

		include ("datenbankschnittstelle.php");
		datenbankaufbau();
		
		$monatJahr_Tag_projektID = $_POST['neuerTerminAnlegen'];	 
		$monatJahr_Tag_projektID = mysql_real_escape_string($monatJahr_Tag_projektID);
		list ($monat_Jahr, $terminDatum, $projektID) = split('[/]', $monatJahr_Tag_projektID);
		
		$tagAusgabe = date_format(date_create($terminDatum.".".$monat_Jahr),'d.m.y');
		$tagDatenbank = date_format(date_create($terminDatum.".".$monat_Jahr),'Y-m-d');


		
		$projektname = getORSetEintraege("SELECT name FROM projekt WHERE projekt_id = '$projektID'");
		
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
							<img class="proplan" src="../Images/proplan.png" alt="proplan" />
							<p class="ueberschrift">Termin Anlegen</p>	
			
							<div class="logout">	
								<a href="logout.php"> <img src="../Images/logout.png" alt="logout" /></a>
							</div>
  
							<div class="profil">
								<a href="profil.php"><img src="../Images/profil_weiß.png" alt="profil" /></a>
							</div>
							
							<p class="pfad">
								<a href="meineProjekte.php">Meine Projekte ></a>
								<a href="projektseite.php?projekt_id=<?php echo $projektID;?>">
								<?php echo $projektname['name'];?></a> > Termin Anlegen
							</p>
							
						</div>   		
					</header>
	
					<div class="hauptbereichunterseiten">
					
						<div id="inhalt"><h3>Termin - Anlegen <?php echo $tagAusgabe; ?></h3>
							
							<form name="terminformAnlegen" action='terminAnlegenScript.php' method='POST'>
									<textarea name="textareatermin" class="textareatermin" rows="3" cols="40" placeholder="Schreiben sie ihre Aufgabe ..." required></textarea> 
									<label class="labeltermin" for="uhrzeit_stunde">Stunde:</label>
									<input type="number" min="0" max="24" step="1" class="uhrzeit_stunde" name="uhrzeit_stunde" value="0" required>
									<label class="labeltermin" for="uhrzeit_minute">Minute:</label>
									<input type="number" min="0" max="59" step="1" class="uhrzeit_minute" name="uhrzeit_minute" value="0" required>
									<div id="hinweis">
									Es können maximal 100 Zeichen in die Datenbank geschrieben werden</div>
									<button type="submit" class="buttonForm" name="terminAnlegen" value="<?php echo $tagDatenbank."/".$projektID;?>">Termin Anlegen</button>
							</form>

						</div>
						
					</div>	
	
					<footer>
						<a href="impressum.html">Impressum</a>&nbsp &nbsp &nbsp &nbsp &nbsp <a href="kontakt.html">Kontakt</a>&nbsp &nbsp &nbsp &nbsp &nbsp <a href="agb.html">AGB</a>
					</footer>
				</body>
			</html>