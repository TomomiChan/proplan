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
		
		$projektID = $_POST['neuesThema'];	 
		//$projektID = mysql_real_escape_string($projektID);

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
							<a href = "meineProjekte.php"><img class="proplan" src="../Images/proplan.png" alt="proplan" /> </a>
							<p class="ueberschrift">Thema erstellen</p>	
			
							<div class="logout">	
								<a href="logout.php"> <img src="../Images/logout.png" alt="logout" /></a>
							</div>
  
							<div class="profil">
								<a href="profil.php"><img src="../Images/profil_weiß.png" alt="profil" /></a>
							</div>
							
							<p class="pfad">
								<a href="meineProjekte.php">Meine Projekte ></a>
								<a href="projektseite.php?projekt_id=<?php echo $projektID;?>">
								<?php echo $projektname['name'];?></a>> Thema erstellen								
							</p>
							
						</div>   		
					</header>
	
					<div class="hauptbereichunterseiten">
					
						<div id="beitragBearbeiten">
							
							<form name="forumformNeuesThema" class="forumformNeuesThema" action='forumNeuesThemaScript.php' method='POST'>
								<h6>Name des Themas: <input id="themaName" type="text" placeholder="Thema Name" name="themaName"  maxlength="28" required/></h6>
								<textarea name="textareaNeuesThema" id="textareaforum" placeholder="Schreiben sie einen Beitrag" required></textarea>
								<button type="submit" class="buttonForm" name="forumNeuesThema" value="<?php echo $projektID;?>">Thema erstellen</button>
							</form>

						</div>
						
					</div>	
	
					<footer>
						<a href="impressum.html">Impressum</a>&nbsp &nbsp &nbsp &nbsp &nbsp <a href="kontakt.html">Kontakt</a>&nbsp &nbsp &nbsp &nbsp &nbsp <a href="agb.html">AGB</a>
					</footer>
				</body>
	</html>