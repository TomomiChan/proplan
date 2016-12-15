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
		$i=0;
		while($row = mysql_fetch_array($result)){		//in row stehen jetzt die einzelnen reihen aus der tabelle user_projekte z.B. (1 1) oder (1 4) / die user_id wurde bei der abfrage aus der Datenbank festgelegt
			$projekte[$i] = $row['projekt_ref'];		//ueberweise dem array nur die projekt_referenzen, nicht mehr die user_id
			//echo $row['projekt_ref'];
			$i++;										//zaehler fuer array
		}	
		
	}
	$aktuelles_projekt = $_GET['projekt_id'];	 
	$aktuelles_projekt = stripcslashes($aktuelles_projekt);
	$aktuelles_projekt = mysql_real_escape_string($aktuelles_projekt);
	
	$nutzer_ist_berechtigt = FALSE;				// Variable um zu gucken ob der Nutzer fuer das Projekt registriert ist
	for($i = 0; $i < count($projekte); $i++){		//geht alle Projekte in der Session durch
		if($aktuelles_projekt == $projekte[$i]){	//und gleicht dieses mit dem Projekt aus der Adresszeile ab
			$nutzer_ist_berechtigt = TRUE;			// Wenn er berechtigt ist true
		}
	}
	if(!$nutzer_ist_berechtigt){					//Ansonsten wird er auf eine andere Seite weitergeleitet
		header("location:fehler.php?fehlercode=Nicht_ihr_projekt");
	}
function monthBack( $timestamp ){
    return mktime(0,0,0, date("m",$timestamp)-1,date("d",$timestamp),date("Y",$timestamp) );
}
function yearBack( $timestamp ){
    return mktime(0,0,0, date("m",$timestamp),date("d",$timestamp),date("Y",$timestamp)-1 );
}
function monthForward( $timestamp ){
    return mktime(0,0,0, date("m",$timestamp)+1,date("d",$timestamp),date("Y",$timestamp) );
}
function yearForward( $timestamp ){
    return mktime(0,0,0, date("m",$timestamp),date("d",$timestamp),date("Y",$timestamp)+1 );
}

function getCalender($date,$headline = array('Mo','Di','Mi','Do','Fr','Sa','So')) {
    $sum_days = date('t',$date);
    $LastMonthSum = date('t',mktime(0,0,0,(date('m',$date)),0,date('Y',$date)));		//der scheiß war falsch im Internet -_- fehlersuche =10min ...
    
    foreach( $headline as $key => $value ) {
        echo "<div class=\"day headline\">".$value."</div>\n";
    }
    
    for( $i = 1; $i <= $sum_days; $i++ ) {
        $day_name = date('D',mktime(0,0,0,date('m',$date),$i,date('Y',$date)));
        $day_number = date('w',mktime(0,0,0,date('m',$date),$i,date('Y',$date)));
        
        if( $i == 1) {
            $s = array_search($day_name,array('Mon','Tue','Wed','Thu','Fri','Sat','Sun'));
            for( $b = $s; $b > 0; $b-- ) {
                $x = $LastMonthSum-($b-1);			//der scheiß war falsch im Internet -_- fehlersuche =10min ...
                echo "<div class=\"day before\">".sprintf("%02d",$x)."</div>\n";
            }
        } 
        
        if( $i == date('d',$date) && date('m.Y',$date) == date('m.Y')) {
            echo "<div class=\"day current\">".sprintf("%02d",$i)."</div>\n";
        } else {
            echo "<div class=\"day normal\">".sprintf("%02d",$i)."</div>\n";
        }
        
        if( $i == $sum_days) {
            $next_sum = (6 - array_search($day_name,array('Mon','Tue','Wed','Thu','Fri','Sat','Sun')));
            for( $c = 1; $c <=$next_sum; $c++) {
                echo "<div class=\"day after\"> ".sprintf("%02d",$c)." </div>\n"; 
            }
        }
    }
	

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
				<img class="gluehbirneunterseiten" src="../Images/gluehbirne.png" width="135px"/>
				<img class="lesezeichenunterseiten" src="../Images/lesezeichen.png" />
				<img class="proplan" src="../Images/proplan.png" alt="proplan" />
				<p class="ueberschrift">
				<?php 
					$result = mysql_query("select name from projekt where projekt_id = '$aktuelles_projekt'")or die("Verbindung zur Datenbank ist fehlgeschlagen".mysql_error());	
					$projektname = mysql_fetch_array($result);
					echo $projektname[0];
				?>
				</p>	
		
				<div class="logout">	
					<a href="logout.php" > <img src="../Images/logout.png" alt="logout" /></a>
				</div>
  
				<div class="profil">
					<a href="profil.php"><img src="../Images/profil_weiß.png" alt="profil" /></a>
				</div>
        
				<p class="pfad">
					<a href="meineProjekte.php">Meine Projekte ></a>
					<?php 
						$result = mysql_query("select name from projekt where projekt_id = '$aktuelles_projekt'")or die("Verbindung zur Datenbank ist fehlgeschlagen".mysql_error());	
						$projektname = mysql_fetch_array($result);
						echo $projektname[0];
					?> 
				</p>
			</div>
		</header>

		<div class="hauptbereichunterseiten">
	
			<div id="todo"><h3>TO-DO</h3>
	
			<?php  
			$result = mysql_query("select * from to_do where projekt_ref = '$aktuelles_projekt'")or die("Verbindung zur Datenbank ist fehlgeschlagen".mysql_error());	
			$x=0;
			while($row = mysql_fetch_array($result)){		
				$todos[$x][0][0] = array($row['to_do_id'],$row['aufgabe'],$row['bearbeitet']);
				$x++;	
			}
			//print_r($todos[0][0][0]);
			
			if(!isset($todos)){
				
			} else {
																//Da Dreidimensionale Arrays doof sind zum Vorstellen, hier mal ne Erklärung
				for($i=0; $i < count($todos); $i++){			//Itterieren über die erste Zeile heisst ueberalle Todos die zum Projekt existieren
					foreach ($todos[$i][0] as $todo) {			//Holt sich die Zeile in dem die Atribute drin stehen und itteriert ueber diese, die Attribute stehen in einem Zweidimensionalen Array
						echo "<div class=\"listetodo\">";
						echo $todo[1];						//deshalb muss man hier noch sagen, welche Stelle des Arrays : $todo[0] = ids ; $todo[1] = aufgabe ; $todo[2] =  bearbeitet oder nicht in 0 oder 1
						echo "<div class=\"zeichen\">

								<form name=\"todoform\" action='todoscript.php' method='POST'>
									<button class=\"buttontodo\" type=\"submit\" name=\"bearbeiten\" value=\"$todo[0]\"><img src=\"../Images/haken.png\" width=\"50px\"></button>
									<button class=\"buttontodo\" type=\"submit\" name=\"erledigt\" value=\"$todo[0]\"><img src=\"../Images/haken.png\" width=\"50px\"></button>
									<button class=\"buttontodo\" type=\"submit\" name=\"loeschen\" value=\"$todo[0]\"><img src=\"../Images/haken.png\" width=\"50px\"></button>
								</form> 

							  </div>
			
							  </div>";		
					}
				}
			}
			?>
	
				<form class="neuesButton" action="neuestodo.php" method="Post">
					<button type="submit" id="button3">To-Do anlegen</button>
				</form>
			</div>
	
	
	<?php
if( isset($_REQUEST['timestamp'])) $date = $_REQUEST['timestamp'];
else $date = time();

$arrMonth = array(
    "January" => "Januar",
    "February" => "Februar",
    "March" => "M&auml;rz",
    "April" => "April",
    "May" => "Mai",
    "June" => "Juni",
    "July" => "Juli",
    "August" => "August",
    "September" => "September",
    "October" => "Oktober",
    "November" => "November",
    "December" => "Dezember"
);
    
$headline = array('Mon','Die','Mit','Don','Fre','Sam','Son');
?>

			<div class="calender">
				<div class="pagination">
					<a href="?timestamp=<?php echo yearBack($date); ?>" class="last">|&laquo;</a> 
					<a href="?timestamp=<?php echo monthBack($date); ?>" class="last">&laquo;</a> 
					<div class="pagihead">
						<span><?php echo $arrMonth[date('F',$date)];?> <?php echo date('Y',$date); ?></span>
					</div>
					<a href="?timestamp=<?php echo monthForward($date); ?>" class="next">&raquo;</a>
					<a href="?timestamp=<?php echo yearForward($date); ?>" class="next">&raquo;|</a>  
				</div>
				<?php getCalender($date,$headline); ?>
				<div class="clear"></div>
				<form class="neuesButton" action="neuentermin.php" method="Post">
					<button type="submit" id="button3">Neuen Termin anlegen</button>
				</form>
			</div>
	
	
	
			<div id="forum"><h4>Forum</h4>
			<?php  
			$i=1;
			$userid=2;
			date_default_timezone_set("Europe/Berlin");
			$timestamp = time();
			$datum = date("d.m.Y",$timestamp);
			$uhrzeit = date("H:i",$timestamp);
	
			//if(!themaexists) -> es gibt noch kein thema else
			while($i<=2){		//hier müsste sowas wie while (themaexists) oder halt mit ner for schleife alle abgehen vielleicht auch mit nem perl script abfragen
				$name = "thema1"; //hier muesste natürlich der echt name übergeben werden
				echo "<div id=\"thema\"><a href=\"forum.php\">Designprojekt $i</a>"; //thema.pl&parameter=$i&projektid=$projektid&userid=$userid ---- unsicher zu übermitteln ... mit forular? kA würde einfach alles verschlüsseln :D 
				for($j=1; $j<=100;$j++){
					echo "&nbsp";
				}
				echo "Versuchsperson $i um $datum ; $uhrzeit Uhr</div>";		//$i = Thema name ...
				$i++;
			}
			?>
	
				<form class="neuesButton" action="neuesthema.php" method="Post">
					<button type="submit" id="button3">Neues Thema</button>
				</form>
	
			</div>	
 	
	
		</div>

		<footer>
			<a href="impressum.html">Impressum</a>&nbsp &nbsp &nbsp &nbsp &nbsp <a href="kontakt.html">Kontakt</a>&nbsp &nbsp &nbsp &nbsp &nbsp <a href="agb.html">AGB</a>
		</footer>


	</body>
</html>