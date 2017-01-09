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

		$result = getORSetEintraegeSchleifen("SELECT * FROM user_projekte WHERE user_ref = '$benutzer_id'");
		$i=0;
		while($row = $result->fetch_array(MYSQLI_BOTH)){		//in row stehen jetzt die einzelnen reihen aus der tabelle user_projekte z.B. (1 1) oder (1 4) / die user_id wurde bei der abfrage aus der Datenbank festgelegt
			$projekte[$i] = $row['projekt_ref'];		//ueberweise dem array nur die projekt_referenzen, nicht mehr die user_id
			$i++;										//zaehler fuer array
		}	
		
	}
	
	$themaID = $_GET['thema'];	 
	//$themaID = mysql_real_escape_string($themaID);

	
	$projektID = getORSetEintraege("SELECT projekt_ref FROM thema WHERE thema_id = '$themaID'");
	$aktuelles_projekt = $projektID[0];	 
	//$aktuelles_projekt = mysql_real_escape_string($aktuelles_projekt);
	
	
	$projektname = getORSetEintraege("SELECT name FROM projekt WHERE projekt_id = '$aktuelles_projekt'");
	
	$nutzer_ist_berechtigt = FALSE;				// Variable um zu gucken ob der Nutzer fuer das Projekt registriert ist
	for($i = 0; $i < count($projekte); $i++){		//geht alle Projekte in der Session durch
		if($aktuelles_projekt == $projekte[$i]){	//und gleicht dieses mit dem Projekt aus der Adresszeile ab
			$nutzer_ist_berechtigt = TRUE;			// Wenn er berechtigt ist true
		}
	}
	if(!$nutzer_ist_berechtigt){					//Ansonsten wird er auf eine andere Seite weitergeleitet
		header("location:fehler.php?fehlercode=Nicht_ihr_projekt");
	}
	
	$result = getORSetEintraegeSchleifen("SELECT * FROM beitrag WHERE thema_ref = '$themaID'");
	$j = 0;
	
	while($row = $result->fetch_array(MYSQLI_BOTH)){		
		$beitragID[$j] = $row['beitrag_id'];	
		$beitragText[$j] = $row['beitrag_text'];	
		$beitragDatum[$j] = $row['datum'];	
		$beitragAnzahlBearbeitet[$j] = $row['bearbeitet'];	
		$beitragBearbeitetDatum[$j] = $row['bearbeitet_datum'];
		$beitragUserID[$j] = $row['user_ref'];
		$j++;
	}	
		
	/*for($i=0; $i < count($beitragID); $i++){		//Testausgabe
		echo $beitragID[$i];	
		echo $beitragText[$i];	
		echo $beitragDatum[$i];	
		echo $beitragAnzahlBearbeitet[$i];	
		echo $beitragBearbeitetDatum[$i];
		echo $beitragUserID[$i];
		echo "<br>";
	}*/
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
				<p class="ueberschrift">
					<?php $themaname = getORSetEintraege("SELECT name FROM thema WHERE thema_id = '$themaID'");
					echo $themaname[0];?>
				</p>	
			
				<div class="logout">	
					<a href="logout.php" > <img src="../Images/logout.png" alt="logout" /></a>
				</div>
  
				<div class="profil">
					<a href="profil.php"><img src="../Images/profil_weiß.png" alt="profil" /></a>
				</div>
   
				<p class="pfad">
					<a href="meineProjekte.php">Meine Projekte ></a>
					<a href="projektseite.php?projekt_id=<?php echo $aktuelles_projekt;?>">
					<?php echo $projektname['name'];?></a> > <?php echo $themaname[0];?>
				</p>
			</div>   		
		</header>
        
        <div class="hauptbereichunterseiten">
	
			<div id="beitraege">
			<?php
			for($i=0; $i < count($beitragID); $i++){		//if set beitragID ist nicht noetig, da wir das so loesen, dass zu jedem erstellten thema automatisch ein beitrag erstellt werden muss 
				$username = getORSetEintraege("SELECT name FROM user WHERE user_id = '$beitragUserID[$i]'");
				$zusatz = "";
				if($beitragAnzahlBearbeitet[$i]>0){
					$zusatz = "-------------<br>Der Beitrag wurde bereits $beitragAnzahlBearbeitet[$i] mal bearbeitet, zuletzt am ".date('d.m.Y \u\m H:i',strtotime($beitragBearbeitetDatum[$i]))."";
				}
				$pfad = getORSetEintraege("select bild from user where user_id = '$beitragUserID[$i]'");
				$bildpfad = $pfad['bild'];
				$bild="";
				if ($pfad['bild']!=""){
					$bild = "<img  src=\"$bildpfad\" height=\"110px\" width=\"100px\" style=\"border-radius: 6px;\" />";
				}else{
					$bild = "<img src='../Images/profilbild_rechteck.png' height=\"110px\" width=\"100px\" style=\"border-radius: 6px;\"/>";
				}
				$bearbeiten = "";
				$loeschen = "";
				if($benutzer_id == $beitragUserID[$i]){
					$bearbeiten = "<form action=\"forumBeitragBearbeiten.php\" method=\"Post\" class=\"formForum\">
										<button type=\"submit\" name=\"beitrag\" value=\"$beitragID[$i]\" class=\"buttonforum\">Bearbeiten</button>
								 /&nbsp</form>";
					if($i==0){
						$loeschen = "<form action=\"forumBeitragLoeschenScript.php\" method=\"Post\" class=\"formForum\">
										<button type=\"submit\" name=\"beitragThemaLoeschen\" value=\"$beitragID[$i]\" class=\"buttonforum\">Löschen</button>
								 -&nbsp</form>";
					}else{
						$loeschen = "<form action=\"forumBeitragLoeschenScript.php\" method=\"Post\" class=\"formForum\">
										<button type=\"submit\" name=\"beitragLoeschen\" value=\"$beitragID[$i]\" class=\"buttonforum\">Löschen</button>
								 -&nbsp</form>";
					}
				}
				echo "<div class =\"beitrag\">
						<div class=\"forumlinks\">
							<div class=\"userbild\">
								$bild
							</div>
							<div class=\"nutzer\">
								$username[0] <br> gepostet am: <br>".date('d.m.Y \u\m H:i',strtotime($beitragDatum[$i]))."
							</div>
						</div>
						<div class =\"forumrechts\">
							<div class=\"leiste\">
								<div style=\"float:right; margin-top:1px;\" >#".($i+1)."</div> $loeschen $bearbeiten 
							</div>
							<div class=\"textforum\">$beitragText[$i]<br><br>$zusatz</div>
						</div>
				</div>";
			}
            ?>



					<h6>Antworten</h6>
					<form name="forumformAntworten" action='forumAntwortenScript.php' method='POST'>
						<textarea name="textareaforum" id="textareaforum" placeholder="Schreiben Sie ihre Antwort ..." required></textarea>
						<button type="submit" class="buttonForm" name="forumAntworten" value="<?php echo $themaID;?>">Antworten</button>
					</form>

			</div>
		</div>
		<footer>
			<a href="impressum.html">Impressum</a>&nbsp &nbsp &nbsp &nbsp &nbsp <a href="kontakt.html">Kontakt</a>&nbsp &nbsp &nbsp &nbsp &nbsp <a href="agb.html">AGB</a>
		</footer>
	</body>
</html> 