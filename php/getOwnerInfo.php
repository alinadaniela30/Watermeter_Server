<?php

	$respObj = array();
	$respObj["status"] = "OK";
	$respObj["statusMsg"] = "";
	$dataObj  = json_decode($_POST['dataObj'], true);
	
		// creare conexiune la mysqli server + db
		$connex=mysqli_connect("localhost","root","","watermeter");
		
		// verifica conexiune
		if(mysqli_connect_errno()) {
			$respObj["status"] = "ERROR";
			$respObj["statusMsg"] = "Error conectiong to server".mysqli_connect_error();
			exit("");
		}
		$sqlquery="SELECT LastName, FirstName, StreetName, StreetNo, AptNo FROM owner where OwnerID = ".(string)$dataObj['OwnerID'];
		
		$result=mysqli_query($connex,$sqlquery);
		$row=mysqli_fetch_array($result,MYSQLI_NUM);
		
//error_log($row[0]);
		
		if ($row) {
			$respObj["LastName"] = $row[0];
			$respObj["FirstName"] = $row[1];
			$respObj["StreetName"] = $row[2];
			$respObj["StreetNo"] = $row[3];
			$respObj["AptNo"] = $row[4];
		} else {
			$respObj["status"] = "ERROR";
			$respObj["statusMsg"] = "Owner info not found !";
		}
	echo json_encode($respObj);
?>