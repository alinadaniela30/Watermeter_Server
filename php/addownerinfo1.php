<?php

	$respObj = array();
	$respObj["status"] = "OK";
	$respObj["statusMsg"] = "";

	$dataObj  = json_decode($_POST['dataObj'], true);
	
//	error_log('$_POST_dataObj:'.$_POST['dataObj']);
//	error_log('$dataObj:'.$dataObj["Username"]);
	
	// creare conexiune la mysqli server + db
	$connex=mysqli_connect("localhost","root","MocanA78","watermeter");
	
	// verifica conexiune
	if(mysqli_connect_errno()) {
		$respObj["status"] = "ERROR";
		$respObj["statusMsg"] = "Error conectiong to server".mysqli_connect_error();
		exit("");
	}

	$sqlquery="INSERT INTO owner (LastName, FirstName, StreetName, StreetNo, AptNo) VALUES ('".$dataObj["LastName"]."','".$dataObj["FirstName"]."','".$dataObj["StreetName"]."',".(string)$dataObj["StreetNo"].",".(string)$dataObj["AptNo"].") ; ";
	$sqlquery.="UPDATE user SET OwnerID = (SELECT OwnerID FROM owner WHERE LastName='".$dataObj["LastName"]."' AND FirstName = '".$dataObj["FirstName"]."') WHERE Username='".$dataObj["UserName"]."' ; ";
	$result = mysqli_multi_query($connex,$sqlquery);

	if ($result) {
		mysqli_close($connex);
		// creare conexiune la mysqli server + db
		$connex=mysqli_connect("localhost","root","","watermeter");
		
		// verifica conexiune
		if(mysqli_connect_errno()) {
			$respObj["status"] = "ERROR";
			$respObj["statusMsg"] = "Error conectiong to server".mysqli_connect_error();
			exit("");
		}
		
		$sqlquery2="SELECT OwnerID FROM user WHERE Username='".$dataObj["UserName"]."'";
		$result2=mysqli_query($connex,$sqlquery2);
		$row=mysqli_fetch_array($result2,MYSQLI_NUM);

		if ($row) {
			$respObj["statusMsg"] = "Owner info updated successfully";
			$respObj["OwnerID"] = $row[0];
		} else {
			$respObj["status"] = "ERROR";
			$respObj["statusMsg"] = "Error updating  owner info!";
		}
	}	
	else {
		$respObj["status"] = "ERROR";
		$respObj["statusMsg"] = "Error updating  owner info: " . mysqli_error($connex);
	}
				
	echo json_encode($respObj);









	
		

		
?>