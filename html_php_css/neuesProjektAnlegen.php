<?php
	session_start();
	$berechtigung = 0;
	if(!isset($_SESSION['name']) OR !isset($_SESSION['id'])){
		$berechtigung = 0;
		header("location:index.php");
	} else {
		$berechtigung = 1;
		$benutzer = $_SESSION['name'];
		$userID = $_SESSION['id'];
		
		
		include ("datenbankschnittstelle.php");
		datenbankaufbau();

	
	$Projektangelegt=false;	
	$geordnet=false;
	
	if (isset($_POST['beginn']) && isset($_POST['ende']) && isset($_POST['projektname'])){
		$tagBeginn=$_POST['beginn'];
		$tagEnde=$_POST['ende'];
		$tagB=false;
		$tagE=false;
		
		if ($tagBeginn <10){
			$tagBeginn= "0".$tagBeginn;
			$tagB=true;
		}

		if ($tagEnde <10){
			$tagEnde ="0".$tagEnde;
			$tagE= true;
			}
					
		$projektname = $_POST['projektname'];
		$projektanfang =$_POST['beginnJahr']."-".$_POST['beginnMonat']."-".$tagBeginn;
		$projektende =$_POST['endeJahr']."-".$_POST['endeMonat']."-".$tagEnde;
		$Projektangelegt=true;
		$geordnet=true;	
	}
	
	$projekt = false;
	if ($geordnet){
		$projektGibtEsSchon = getORSetEintraege("select projekt_id from projekt where name = '$projektname' AND beginn_projekt = '$projektanfang' AND ende_projekt = '$projektende' AND ersteller_ref = '$userID'");
		if($projektGibtEsSchon!=""){
			header("location:fehler.php?fehlercode=Sie haben ein Projekt mit identischen Einträgen");	
		}else{
			$result=getORSetEintraegeSchleifen("INSERT INTO projekt (beginn_projekt, ende_projekt, name, ersteller_ref) VALUES ('$projektanfang','$projektende','$projektname','$userID')");
			$projekt=true;
		}
	}
	

	if($projekt){
		$projektID = getORSetEintraege("select projekt_id from projekt where name = '$projektname' AND beginn_projekt = '$projektanfang' AND ende_projekt = '$projektende' AND ersteller_ref = '$userID'");
		$result = getORSetEintraegeSchleifen("INSERT INTO user_projekte (user_ref, projekt_ref) VALUES ('$userID','$projektID[0]')");
	}

	if (isset($_POST['textareaprojekt'])){
		$emails = $_POST['textareaprojekt'];
		$emails = str_replace(' ','',$emails); 
		$arrayEmails = explode(',',$emails);
		$newArrayEmails = array_values(array_unique($arrayEmails));		//anmerkung Christoph, um das Spammen von der selben Mail beim Anlegen zu verhinden filtert er erst alle doppelten Mails und uebergibt sie einem neuem array, dessen Keys wieder bei 0 anfangen (das alte haette dennoch alle key eintraege und es wuerde zu fehler beim schleifen durchlauf fuehren)
		for ($i=0; $i < count($newArrayEmails);$i++){
			$user_ref = getORSetEintraege("select user_id from user where email = '$newArrayEmails[$i]'");
			if($user_ref==""){
			}else{	
				$result = getORSetEintraegeSchleifen("INSERT INTO user_projekte (user_ref, projekt_ref) VALUES ('$user_ref[0]','$projektID[0]')");
			}
		}
		
	}

	header("Location: meineProjekte.php"); 	
	
	}
?>