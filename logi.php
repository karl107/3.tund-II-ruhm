<?php

//GET ja POSTI muutujad
	// var_dump ($_GET);
	// echo "<br>";
	// var_dump ($_POST);
	
	$signupEmailError=""; //errorite loome, et saaks kasutada
	$signupPasswordError="";
	$signupFirstNameError="";
	$signupLastNameError="";
	$signupDateError="";
	$termsAgreementError="";
	
	
	
	// on üldse olemas selline muutuja
	if(isset($_POST["signupEmail"])){
		
		//jah on olemas
		//kas on tühi
		if(empty($_POST["signupEmail"])){
			
			$signupEmailError= "E-postiaadress on sisestamata";
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
	
?>

<!DOCTYPE html>
<html>
<head>
	<title>Logi sisse või loo kasutaja</title>
</head>
<body>

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
		<input name="signupEmail" type="text"> <?php echo $signupEmailError; ?>
		<br><br>
		
		<input name="signupPassword" placeholder="Parool" type="password"> <?php echo $signupPasswordError; ?>
		<br><br>
		
		<input name="signupSex" type="radio" value="Mees"> Mees
		<input name="signupSex" type="radio" value="Naine"> Naine
		<br><br>
		<input type="checkbox" name="newsLetter" checked> Soovin uudiskirja
		<br><br>
		<input type="submit" value="Loo kasutaja">
		
		
	</form>

</body>
</html>