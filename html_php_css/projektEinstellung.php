<?php
/**
  * Das Dokument stellt ein Interface fuer den Nutzer um Projekteinstellungen vornehmen zu koennen und gibt ihn zur Unterstuetzung Aktuelle Eintraege aus der Datenbank
  * @author Christoph Suhr
  */
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
		
		$projektID = $_POST['einstellen'];	 
		//$projektID = mysql_real_escape_string($projektID);
		
		$projektname = getORSetEintraege("SELECT name FROM projekt WHERE projekt_id = '$projektID'");
		$projektBeginn = getORSetEintraege("SELECT beginn_projekt FROM projekt WHERE projekt_id = '$projektID'");
		$projektEnde = getORSetEintraege("SELECT ende_projekt FROM projekt WHERE projekt_id = '$projektID'");
		$erstellerREF = getORSetEintraege("SELECT ersteller_ref FROM projekt WHERE projekt_id = '$projektID'");
		$zusatz="";
		if($erstellerREF[0] == $benutzer_id){		//Abfrage ob der angemeldete Nutzer ersteller ist, wenn ja Hinweis
			$zusatz = "<div class=\"hinweistext\">Sie sind ersteller des Projektes, wenn sie dieses Entfernen, wird es auch für alle Projektteilnehmer gelöscht!</div>";
		}
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
								<?php echo $projektname['name'];?></a> > Projekteinstellungen
							</p>
							
						</div>   		
					</header>
	
					<div class="hauptbereichunterseiten">
					
						<div id="inhalt"><h3>Projekteinstellungen</h3>
							<form name="prEinstellungForm" class="prEinstellungForm" action='projektEinstellungAendern.php' method='POST'>
								<div class="eintraege">
									<div class="inputSchrift">Projektname: </div><input class="projektInput" type="text" name="projektname" placeholder="Projektname" value="<?php echo $projektname['name'];?>" required>
									<button type="submit" id="button6" name="nameaendern" value="<?php echo $projektID;?>">Namen ändern</button>
								</div>
								<div class="eintraege"> 
									<div class="wrap"><div class="jahrmonattag">Jahr:</div><div class="jahrmonattag">Monat:</div><div class="jahrmonattag">Tag:</div></div>
									<div class="inputSchrift">Projektbeginn: </div><input class="datumInput" type="number" min="2001" max ="3030" name="beginnJahr"  placeholder="Jahr" value="<?php echo date('Y',strtotime($projektBeginn[0]));?>" required>
									<input class="datumInput" type="number" min="01" max="12" name="beginnMonat"  placeholder="Monat" value="<?php echo date('m',strtotime($projektBeginn[0]));?>" required>
									<input class="datumInput" type="number" min="01" max="31" name="beginnTag"  placeholder="Tag" value="<?php echo date('d',strtotime($projektBeginn[0]));?>" required>
									<button type="submit" id="button6" name="beginnaendern" value="<?php echo $projektID;?>">Beginn ändern</button>
								</div>
								<div class="eintraege">
									<div class="wrap"><div class="jahrmonattag">Jahr:</div><div class="jahrmonattag">Monat:</div><div class="jahrmonattag">Tag:</div></div>
									<div class="inputSchrift">Projektende: </div><input class="datumInput" type="number" min="2001" max ="3030" name="endeJahr"  placeholder="Jahr" value="<?php echo date('Y',strtotime($projektEnde[0]));?>"required>
									<input class="datumInput" type="number" min="01" max="12" name="endeMonat"  placeholder="Monat" value="<?php echo date('m',strtotime($projektEnde[0]));?>" required>
									<input class="datumInput" type="number" min="01" max="31" name="endeTag"  placeholder="Tag" value="<?php echo date('d',strtotime($projektEnde[0]));?>" required>
									<button type="submit" id="button6" name="endeaendern" value="<?php echo $projektID;?>">Ende ändern</button>
								</div>
								<div class="eintraege">
									<div class="inputSchrift">Nutzer hinzufügen: </div><textarea name="textareanutzerhinzufuegen" class="textareaprojekteinstellungen" rows="5" cols="24" placeholder="Emailadressen mit Komma getrennt eingeben: maxmuster@domain.de, andre@domain.de, ..."></textarea> 
									<button type="submit" id="button7" name="nutzerhinzufuegen" value="<?php echo $projektID;?>">Nutzer hinzufügen</button>
								</div>
								<div class="eintraege">
									<div class="inputSchrift">Projekt entfernen: </div><?php echo $zusatz;?>
									<button type="submit" id="button6" name="projektentfernen" value="<?php echo $projektID;?>">Projekt entfernen</button>
								</div>
							</form>
						</div>
						
					</div>	
	
					<footer>
						<a href="impressum.php">Impressum</a>&nbsp &nbsp &nbsp &nbsp &nbsp <a href="kontakt.html">Kontakt</a>&nbsp &nbsp &nbsp &nbsp &nbsp  <a href="nutzungsbestimmung.php">Nutzungsbestimmung</a>
					</footer>
				</body>
			</html>