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
		
		mysql_connect("localhost", "root", "");
		mysql_select_db("pro_db");
		
		
		if(isset($_POST['bearbeiten'])){
			$bearbeiten = $_POST['bearbeiten'];
			$bearbeiten = stripcslashes($bearbeiten);
			$bearbeiten = mysql_real_escape_string($bearbeiten);
			
			$result = mysql_query("select projekt_ref from to_do WHERE to_do_id = '$bearbeiten'")or die("Verbindung zur Datenbank ist fehlgeschlagen".mysql_error());
			$projektID = mysql_fetch_array($result);
			$projektID = $projektID['projekt_ref'];
			
			$result = mysql_query("select name from projekt where projekt_id = '$projektID'")or die("Verbindung zur Datenbank ist fehlgeschlagen".mysql_error());	
			$projektname = mysql_fetch_array($result);
			
			echo "<html>
			<head>
				<meta charset=\"utf-8\">
				<link href=\"https://fonts.googleapis.com/css?family=Ubuntu\" rel=\"stylesheet\">
				<title> Proplaner </title>
				<link rel=\"stylesheet\" href=\"style.css\">
			</head>
				<body>
					<header class=\"headerunterseiten\">
						<div class=\"lilabannerunterseiten\">
							<img class=\"lesezeichenunterseiten\" src=\"../Images/lesezeichen.png\" />
							<img class=\"gluehbirneunterseiten\" src=\"../Images/gluehbirne.png\" width=\"135px\" alt=\"gluehbirne\" />
							<img class=\"proplan\" src=\"../Images/proplan.png\" alt=\"proplan\" />
							<p class=\"ueberschrift\">TO-DO Bearbeiten</p>	
			
							<div class=\"logout\">	
								<a href=\"logout.php\"> <img src=\"../Images/logout.png\" alt=\"logout\" /></a>
							</div>
  
							<div class=\"profil\">
								<a href=\"profil.php\"><img src=\"../Images/profil_weiß.png\" alt=\"profil\" /></a>
							</div>
							
							<p class=\"pfad\">
								<a href=\"meineProjekte.php\">Meine Projekte ></a>
								<a href=\"projektseite.php?projekt_id=$projektID\">"; 
								echo $projektname['name']; 
								echo"></a>
								TO-DO bearbeiten
							</p>
							
						</div>   		
					</header>
	
					<div class=\"hauptbereichunterseiten\">
					
					</div>	
	
					<footer>
						<a href=\"impressum.html\">Impressum</a>&nbsp &nbsp &nbsp &nbsp &nbsp <a href=\"kontakt.html\">Kontakt</a>&nbsp &nbsp &nbsp &nbsp &nbsp <a href=\"agb.html\">AGB</a>
					</footer>
				</body>
			</html>";
			
			//echo $bearbeiten;
			//echo "bearbeitet";
		}
		if(isset($_POST['erledigt'])){
			$erledigt = $_POST['erledigt'];
			$erledigt = stripcslashes($erledigt);
			$erledigt = mysql_real_escape_string($erledigt);
		
			$rueckgabe = mysql_query("UPDATE to_do SET bearbeitet = '1' WHERE to_do_id = '$erledigt'")or die("Verbindung zur Datenbank ist fehlgeschlagen".mysql_error());
			$result = mysql_query("select projekt_ref from to_do WHERE to_do_id = '$erledigt'")or die("Verbindung zur Datenbank ist fehlgeschlagen".mysql_error());
			$projekt_id = mysql_fetch_array($result);
			$projekt_id = $projekt_id['projekt_ref'];
			header("location:projektseite.php?projekt_id=$projekt_id");
		}
		if(isset($_POST['loeschen'])){
			$loeschen = $_POST['loeschen'];
			$loeschen = stripcslashes($loeschen);
			$loeschen = mysql_real_escape_string($loeschen);
			
			$result = mysql_query("select projekt_ref from to_do WHERE to_do_id = '$loeschen'")or die("Verbindung zur Datenbank ist fehlgeschlagen".mysql_error());
			$projekt_id = mysql_fetch_array($result);
			$projekt_id = $projekt_id['projekt_ref'];
			
			$rueckgabe = mysql_query("DELETE FROM to_do WHERE to_do_id = '$loeschen'")or die("Verbindung zur Datenbank ist fehlgeschlagen".mysql_error());
			
			header("location:projektseite.php?projekt_id=$projekt_id");
		}

		
		//Verbinung zu Datenbank
		mysql_connect("localhost", "root", "");
		mysql_select_db("pro_db");

		$result = mysql_query("select * from user_projekte where user_ref = '$benutzer_id'")or die("Verbindung zur Datenbank ist fehlgeschlagen".mysql_error());
	

	}

?>