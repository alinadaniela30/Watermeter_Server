<?php

	$respObj = array();
	$respObj["status"] = "OK";
	$respObj["statusMsg"] = "";

	$dataObj  = json_decode($_POST['dataObj'], true);
	
	error_log('$_POST_dataObj:'.$_POST['dataObj']);
//	error_log('$dataObj:'.$dataObj["Username"]);

//validarile se fac tot timpul inainte de conexiunea la baza

	// creare conexiune la mysqli server + db
	$connex=mysqli_connect("localhost","root","MocanA78","watermeter");
	
	// verifica conexiune
	if(mysqli_connect_errno()) {
		$respObj["status"] = "ERROR";
		$respObj["statusMsg"] = "Error conectiong to server".mysqli_connect_error();
		exit("");
	}
	
	$sqlquery="UPDATE owner SET LastName='".$dataObj["LastName"]."', FirstName='".$dataObj["FirstName"]."', StreetName='".$dataObj["StreetName"]."', StreetNo=".(string)$dataObj["StreetNo"].", AptNo=".(string)$dataObj["AptNo"]." WHERE OwnerID = ".(string)$dataObj['OwnerID'];
//			   "UPDATE owner SET LastName='Mocan'".",FirstName='Alina'" 	
	$result=mysqli_query($connex,$sqlquery);
	
	$affected = mysqli_affected_rows($connex);
	if($affected > 0)
		$respObj["statusMsg"] = "Owner info updated successfully";
	else {
		$respObj["status"] = "ERROR";
		$respObj["statusMsg"] = "Error updating  owner info: " . mysqli_error($connex);
	}
				
	echo json_encode($respObj);
		
?>