<?php 
	session_start();
	$berechtigung = 0;
	if(!isset($_SESSION['name']) OR !isset($_SESSION['id'])){
		$berechtigung = 0;
		header("location:index.html");
	} else {
		$berechtigung = 1;
		$benutzer = $_SESSION['name'];
		$benutzer_id = $_SESSION['id'];
	
		//Verbinung zu Datenbank
		mysql_connect("localhost", "root", "");
		mysql_select_db("pro_db");

		$result = mysql_query("select * from user_projekte where user_ref = '$benutzer_id'")or die("Verbindung zur Datenbank ist fehlgeschlagen".mysql_error());
		$projekte[] = array();		// lege ein leeres Array fuer Projekte an
		$i=0;
		while($row = mysql_fetch_array($result)){		//in row stehen jetzt die einzelnen reihen aus der tabelle user_projekte z.B. (1 1) oder (1 4) / die user_id wurde bei der abfrage aus der Datenbank festgelegt
			$projekte[$i] = $row['projekt_ref'];		//ueberweise dem array nur die projekt_referenzen, nicht mehr die user_id
			//echo $row['projekt_ref'];
			$i++;										//zaehler fuer array
		}	
		$_SESSION['projekte'] = $projekte;
	}
	?> 
<html xmlns="http://www.w3.org/1999/xhtml">
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
			<p class="ueberschrift">Meine Projekte</p>	
			
			<div class="logout">	
				<a href="logout.php"> <img src="../Images/logout.png" alt="logout" /></a>
			</div>
  
			<div class="profil">
				<a href="profil.php"><img src="../Images/profil_weiß.png" alt="profil" /></a>
			</div>
   
   			
			</div>   		
		</header>
	
    <div class="hauptbereichunterseiten">
		<div id="alleOrdner">  
		<?php 
		if($berechtigung == 1){
			foreach ($projekte as $p) {
			$result = mysql_query("select name from projekt where projekt_id = '$p'")or die("Verbindung zur Datenbank ist fehlgeschlagen".mysql_error());	
			$namen = mysql_fetch_array($result);
			//echo $namen['name'];	
			echo"<div class=\"ordnerGruen\">";	
				echo"<a class=\"a1\" href=\"projektseite.php?projekt_id=$p\"><img src=\"../Images/ordnerGruen.png\" alt=\"ordner\">";	
				echo"<p id=\"projektname\">";
					echo $namen['name']; 
				echo"</p></a>";
			echo"</div>";
			}
		}
		?> 
			
			<div id="ordnerGrau">
                <a href="neuesProjekt.php" > <img src="../Images/ordnerGrau.png" alt="logout" /></a>
			</div>
		</div>  
	 
		
	</div>	
	
	<footer>
			<a href="impressum.html">Impressum</a>&nbsp &nbsp &nbsp &nbsp &nbsp <a href="kontakt.html">Kontakt</a>&nbsp &nbsp &nbsp &nbsp &nbsp <a href="agb.html">AGB</a>
		</footer>
	</body>
</html>
