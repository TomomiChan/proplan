<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php
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
				<p class="ueberschrift">Designprojekt</p>	
		
				<div class="logout">	
					<a href="index.html" > <img src="../Images/logout.png" alt="logout" /></a>
				</div>
  
				<div class="profil">
					<a href="profil.html"><img src="../Images/profil_weiß.png" alt="profil" /></a>
				</div>
        
				<p class="pfad">
					<a href="javascript:history.back()">Meine Projekte ></a>
					<?php 
					$projektname = "Designprojekt";
					$projektid = "2"; //hier muesste die richtige id aus der datenbank geholt werden
					echo $projektname;
					//echo "$_POST["Projektname"]";
					?> 
				</p>
			</div>
		</header>

		<div class="hauptbereichunterseiten">
	
			<div id="todo"><h3>TO-DO</h3>
	
			<?php  
			$i=1;	
			//if(!todoexists) -> es gibt noch kein todo else
			while($i<=4){		//hier müsste sowas wie while (todoexist) oder halt mit ner for schleife alle abgehen vielleicht auch mit nem perl script abfragen
				echo "<div class=\"listetodo\">Testtodo $i		
			
				<div class=\"zeichen\">

					<form action='todoscript.php' method='POST'>
						<input type=\"image\" src=\"../Images/haken.png\" width=\"50px\" value=\"bearbeiten.$i\" name=\"bearbeiten\" />
						<input type=\"image\" src=\"../Images/haken.png\" width=\"50px\" value=\"erledigt.$i\" name=\"erledigt\" />
						<input type=\"image\" src=\"../Images/haken.png\" width=\"50px\" value=\"loeschen.$i\" name=\"loeschen\" />
					</form> 

				</div>
			
				</div>";		//$i = todoname ...
			
				$i++;
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