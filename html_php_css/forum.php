<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
			<p class="ueberschrift">Designvorschläge</p>	
			
			<div class="logout">	
				<a href="index.php" > <img src="../Images/logout.png" alt="logout" /></a>
			</div>
  
			<div class="profil">
				<a href="profil.html"><img src="../Images/profil_weiß.png" alt="profil" /></a>
			</div>
   
   			<p class="pfad">
					<a href="javascript:history.back()">Meine Projekte ></a>
					<?php 
					$projektname = "Designprojekt";
					$projektid = "2"; //hier muesste die richtige id aus der datenbank geholt werden
					$thema ="Designvorschlaege";
					echo "$projektname > $thema";
					//echo "$_POST["Projektname"]";
					?> 
				</p>
			
			
			</div>   		
		</header>
        
        <div class="hauptbereichunterseiten">
	

<div id="beitraege">

<div class ="beitrag">

	
	<div class="userbild">


	</div>
    <div class="nutzer">
        Nutzer 1 <br> gepostet um: 13.15 Uhr 
    </div>
    
	<div class="beispieltext">
        <h3 > Überschrift</h3>
    </div>
	
	<div class="textforum">
	 
	
	</div>

</div>
            
    <div class ="beitrag">

	<div class="userbild">

	</div>
	
    <div class="nutzer">
        Nutzer 1 <br> gepostet um: 13.15 Uhr 
    </div>
    
    <div class="beispieltext">
        <h3 > BEISPIELTEXT_1</h3>
    </div>

	<div class="textforum">
	</div>
</div>

<div class="verfassen">
    <h3> Antworten:</h3>
    <form action="forum_antwort.html" method="post" >
  
  <textarea id="textareaforum" name="text" cols="90" rows="10"></textarea> 
  <form class="neuesButton" action="forumantworten.php" method="Post">
		<button type="submit" id="button3">Antworten</button>
</form>
</form>
</div>
</div>

	<footer>
		<a href="impressum.html">Impressum</a>&nbsp &nbsp &nbsp &nbsp &nbsp <a href="kontakt.html">Kontakt</a>&nbsp &nbsp &nbsp &nbsp &nbsp <a href="agb.html">AGB</a>
	</footer>
</body>
</html> 