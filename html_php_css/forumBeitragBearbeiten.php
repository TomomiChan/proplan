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
		
		$beitragID = $_POST['beitrag'];	 
		//$beitragID = mysql_real_escape_string($beitragID);

		$themaID = getORSetEintraege("SELECT thema_ref FROM beitrag WHERE beitrag_id = '$beitragID'");
		$projektID = getORSetEintraege("SELECT projekt_ref FROM thema WHERE thema_id = '$themaID[0]'");
		
		$projektname = getORSetEintraege("SELECT name FROM projekt WHERE projekt_id = '$projektID[0]'");
		$themaName = getORSetEintraege("SELECT name FROM thema WHERE thema_id = '$themaID[0]'");
		
		$text = getORSetEintraege("SELECT beitrag_text FROM beitrag WHERE beitrag_id = '$beitragID'");

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
							<p class="ueberschrift">Beitrag Bearbeiten</p>	
			
							<div class="logout">	
								<a href="logout.php"> <img src="../Images/logout.png" alt="logout" /></a>
							</div>
  
							<div class="profil">
								<a href="profil.php"><img src="../Images/profil_weiß.png" alt="profil" /></a>
							</div>
							
							<p class="pfad">
								<a href="meineProjekte.php">Meine Projekte ></a>
								<a href="projektseite.php?projekt_id=<?php echo $projektID[0];?>">
								<?php echo $projektname['name'];?> ></a>
								<a href="forum.php?thema=<?php echo $themaID[0];?>">
								<?php echo $themaName['name'];?></a> > Beitrag bearbeiten								
							</p>
							
						</div>   		
					</header>
	
					<div class="hauptbereichunterseiten">
					
						<div id="beitragBearbeiten"><h6>Beitrag - Bearbeiten</h6>
							
							<form name="forumformBeitragBearbeiten" class="forumformBeitragBearbeiten" action='forumBeitragAendernScript.php' method='POST'>
								<textarea name="textareaforum" id="textareaforum" placeholder="Bearbeiten Sie ihre Antwort ..." required><?php echo $text[0]; ?></textarea>
								<button type="submit" class="buttonForm" name="forumBeitragBearbeiten" value="<?php echo $beitragID;?>">Bearbeiten</button>
							</form>

						</div>
						
					</div>	
	
					<footer>
						<a href="impressum.html">Impressum</a>&nbsp &nbsp &nbsp &nbsp &nbsp <a href="kontakt.html">Kontakt</a>&nbsp &nbsp &nbsp &nbsp &nbsp <a href="agb.html">AGB</a>
					</footer>
				</body>
	</html>