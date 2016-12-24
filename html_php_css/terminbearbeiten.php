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
		
		$terminDatum_projektID = $_POST['termin_bearbeiten'];	 
		$terminDatum_projektID = mysql_real_escape_string($terminDatum_projektID);

		list ($terminDatum, $projektID) = split('[/]', $terminDatum_projektID);
		//echo "terminDatum: $terminDatum; ProjektID: $projektID;";
		//echo $terminDatum_projektID;
		$projektname = getORSetEintraege("SELECT name FROM projekt WHERE projekt_id = '$projektID'");
		
		$result = getORSetEintraegeSchleifen("SELECT * FROM termin WHERE projekt_ref = '$projektID' AND datum ='$terminDatum'");
		$j = 0;
		while($row = mysql_fetch_array($result)){		
			$terminID[$j] = $row['termin_id'];	
			$terminName[$j] = $row['termin_name'];	
			$terminDatum[$j] = $row['datum'];	
			$terminUhrzeit[$j] = $row['uhrzeit'];	
			$j++;
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
							<img class="proplan" src="../Images/proplan.png" alt="proplan" />
							<p class="ueberschrift">Termin Bearbeiten</p>	
			
							<div class="logout">	
								<a href="logout.php"> <img src="../Images/logout.png" alt="logout" /></a>
							</div>
  
							<div class="profil">
								<a href="profil.php"><img src="../Images/profil_weiß.png" alt="profil" /></a>
							</div>
							
							<p class="pfad">
								<a href="meineProjekte.php">Meine Projekte ></a>
								<a href="projektseite.php?projekt_id=<?php echo $projektID;?>">
								<?php echo $projektname['name'];?></a> > Termin bearbeiten
							</p>
							
						</div>   		
					</header>
	
					<div class="hauptbereichunterseiten">
					
						<div id="todo"><h3>Termin - Bearbeiten</h3>
							
							<?php
							for($i=0; $i < count($terminID); $i++){
							echo "<form name=\"terminformAendern\" action='terminAendernScript.php' method='POST'>
									<textarea name=\"textareatermin\" class=\"textareatermin\" rows=\"3\" cols=\"40\" placeholder=\"Schreiben sie ihre Aufgabe ...\" required>"; 
										echo $terminName[$i]; 
										echo "</textarea> 
										<label class=\"labeltermin\" for=\"uhrzeit\">Uhrzeit (Bsp.: 04:35):</label>
										<input type=\"text\" class=\"uhrzeit\" name=\"uhrzeit\" value=".date_format(date_create($terminUhrzeit[$i]),'H:i')." required>
									<div id=\"hinweis\">
									Es können maximal 100 Zeichen in die Datenbank geschrieben werden</div>
										<button type=\"submit\" class=\"todoButtonForm\" name=\"terminAendern\" value=\"$terminID[$i]\">Termin ändern</button>
								</form>";
							}
							?>
							
						</div>
						
					</div>	
	
					<footer>
						<a href="impressum.html">Impressum</a>&nbsp &nbsp &nbsp &nbsp &nbsp <a href="kontakt.html">Kontakt</a>&nbsp &nbsp &nbsp &nbsp &nbsp <a href="agb.html">AGB</a>
					</footer>
				</body>
			</html>
