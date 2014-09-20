<?php

	$respObj = array();
	$respObj["status"] = "OK";
	$respObj["statusMsg"] = "";
	$respObj["OwnerID"] = 0;

	$dataObj  = json_decode($_POST['dataObj'], true);
	
//	error_log('$_POST_dataObj:'.$_POST['dataObj']);
//	error_log('$dataObj:'.$dataObj["Username"]);
	
	if (!empty($dataObj["Username"]) && !empty($dataObj["Password"])) {
		// verifici in DB

		// creare conexiune la mysqli server + db
		$connex=mysqli_connect("localhost","root","MocanA78","watermeter");
		
		// verifica conexiune
		if(mysqli_connect_errno()) {
			$respObj["status"] = "ERROR";
			$respObj["statusMsg"] = "Error conectiong to server".mysqli_connect_error();
			exit("");
		}
		
	// restrictie caractere speciale in stringurile introduse
	// $Username=mysqli_real_escape_string($connex,$dataObj["Username"]);
	// $Password=mysqli_real_escape_string($connex,$dataObj["Password"]);
			
		$sqlquery="SELECT OwnerID FROM user where Username = '".$dataObj["Username"]."' and Password = '".$dataObj["Password"]."'";
		
		$result=mysqli_query($connex,$sqlquery);
		$row=mysqli_fetch_array($result,MYSQLI_NUM);
		
		if ($row) {
			$respObj["OwnerID"] = $row[0];
		} else {
			$respObj["status"] = "ERROR";
			$respObj["statusMsg"] = "Username sau parola sunt incorecte!";
		}
		
	} else {
		$respObj["status"] = "ERROR";
		$respObj["statusMsg"] = "Nu ati completat username sau parola!";
	}            
				
	echo json_encode($respObj);
?>