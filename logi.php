<?php

	require("../../config.php"); // ees on public html kaustast väljaminek, võtab configust andmed, kopeerib siia

	//echo hash("sha512", "karl");

	//GET ja POSTI muutujad
	// var_dump ($_GET);
	// echo "<br>";
	// var_dump ($_POST);
	
	// MUUTUJAD
	$signupEmailError=""; //errorite loome, et saaks kasutada
	$signupPasswordError="";
	$signupFirstNameError="";
	$signupLastNameError="";
	$signupDateError="";
	$termsAgreementError="";
	$signupEmail="";
	$signupSex="";
	
	
	
	// on üldse olemas selline muutuja
	if(isset($_POST["signupEmail"])){
		
		//jah on olemas
		//kas on tühi
		if(empty($_POST["signupEmail"])){
			
			$signupEmailError= "E-postiaadress on sisestamata";
		}else{

			//email olemas
			$signupEmail=$_POST["signupEmail"];
		}
		
	}
	
	if(isset($_POST["signupPassword"])){
		
		if(empty($_POST["signupPassword"])){
			
			$signupPasswordError= "Parool on kohustuslik";
		}else{
			//kui parool oli olemas -isset
			//parool ei olnud tühi -empty
			
			if(strlen($_POST["signupPassword"])<8){
				
				$signupPasswordError="Parool peab olema vähemalt 8 tähemärki pikk";
			}
		}
	}

	if(isset($_POST["signupFirstName"])){
		
		if(empty($_POST["signupFirstName"])){
			
			$signupFirstNameError="Eesnime sisestamine on kohustuslik";
		}
	}
	if(isset($_POST["signupLastName"])){
		
		if(empty($_POST["signupLastName"])){
			
			$signupLastNameError="Perenime sisestamine on kohustuslik";
		}
	}
	
	if( isset( $_POST["signupSex"] ) ){
		
		if(!empty( $_POST["signupSex"] ) ){
		
			$signupSex = $_POST["signupSex"];
			
		}
		
	} 
	
	// peab olema email ja parool
	// ühtegi errorite
	
	if($signupEmailError == "" && //kontroll, et errorid on tühjad (loogiliselt võiks olla errorid pärast POSTe)
		empty ($signupPasswordError) &&
		isset($_POST["signupEmail"])	&&
		isset($_POST["signupPassword"]) 
			){
			
		//salvestame ab'i
		
		echo "Salvestan... <br>";
		echo "email: ".$signupEmail."<br>";
		echo "password: ".$_POST["signupPassword"]."<br>";
		
		$password = hash("sha512", $_POST["signupPassword"]);
		
		echo "password hashed: ".$password. "<br>";

		//echo $serverUsername;
		
		// ÜHENDUS andmebaasiga
		$database = "if16_karlkruu";
		$mysqli = new mysqli($serverHost, $serverUsername, $serverPassword, $database);
		
		// sqli rida
		$stmt=$mysqli->prepare("INSERT INTO user_sample (email, password) VALUES (?, ?)");
		
		echo $mysqli->error; // spetsifitseerib errori prepare real^
		
		// stringina üks täht iga muutuja kohta (?), mis tüüp
		// string - s
		// integer - i
		// float (double) - d
		// küsimärgid asendada muutujaga
		$stmt->bind_param("ss", $signupEmail, $password);
		
		// täida käsku
		if($stmt->execute()) {
			
			echo "salvestamine õnnestus";
		
		}else{
			echo "ERROR ".$stmt->error;
		}
	
		// panen ühenduse kinni
		$stmt->close();
		$mysqli->close();
		
		}
	
?>

<!DOCTYPE html>
<html>
<head>
	<title>Logi sisse või loo kasutaja</title>
</head>
<body style="background-color:white;"> <!--Taustavärv-->

	<h1>Logi sisse</h1>
	<form method="POST"><!--Refreshimisel küsib kinnitust; andmed ei jääks URL-i-->
		
		<label>E-post</label><br>
		<input name="loginEmail" type="text"><br><br>
		
		<input name="loginPassword" placeholder="Parool" type="password"><br><br>
		
		<input type="submit" value="Logi sisse">
		
	<h1>Loo kasutaja</h1>
	<form method="POST">
		
		<label>Nimi</label><br>
		<input name="signupFirstName" placeholder="Eesnimi" type="text"> <?php echo $signupFirstNameError; ?><br>
		<input name="signupLastName" placeholder="Perenimi" type="text"> <?php echo $signupLastNameError; ?><br><br>
		
		<label>Sünnipäev</label><br>
		<input type="date" name="signupDate"><br><br>
		
		<label>E-post</label><br>
		<input name="signupEmail" type="text" value="<?=$signupEmail;?>">  <?php echo $signupEmailError; ?> <!--value jätab emaili sisestatuks, siin echo lühendina-->
		<br><br>
		
		<input name="signupPassword" placeholder="Parool" type="password"> <?php echo $signupPasswordError; ?>
		<br><br>
		
		
		<?php if($signupSex == "Mees") { ?>
			<input name="signupSex" type="radio" value="Mees" checked> Mees
		<?php }else{ ?>
			<input name="signupSex" type="radio" value="Mees"> Mees
		<?php } ?>
		
	
		<?php if($signupSex == "Naine") { ?>
			<input name="signupSex" type="radio" value="Naine" checked> Naine
		<?php }else{ ?>
			<input name="signupSex" type="radio" value="Naine"> Naine
		<?php } ?>
		
		
		<br><br>
		<input type="checkbox" name="newsLetter" checked> Soovin uudiskirja
		<br><br>
		<input type="submit" value="Loo kasutaja">
		
		
	</form>

</body>
</html>