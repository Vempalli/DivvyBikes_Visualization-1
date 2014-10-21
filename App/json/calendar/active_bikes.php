<?php
	$username = "akumar34"; 
	$password = "password1";   
	$host = "bicyclerace6.mysql.uic.edu";
	$database="bicyclerace6";
    
	$server = mysql_connect($host, $username, $password);
	$connection = mysql_select_db($database, $server);

	$no_of_bins = 60*24;
	$range = 60*24;
	$intervals = floor($range/$no_of_bins);
	$lower = date_create('6/27/2013 00:00');
	$higher = date_create('6/27/2013 00:00');
	date_add($higher, date_interval_create_from_date_string($intervals . " minutes"));

	$sql = "";
	for($multiplier = 1; $multiplier < $no_of_bins + 1; $multiplier++){	
		if($multiplier != $no_of_bins){
			$sql .= ("SELECT DISTINCT '" 
			     . (date_format($lower,"G:i")) .
				"' AS TIME_INTERVAL, BIKEID
				FROM trips_data 
				WHERE '" . (date_format($lower,"G:i")) . "'<= TIME(STR_TO_DATE(STARTTIME,'%m/%d/%Y %H:%i')) AND 
				TIME(STR_TO_DATE(STOPTIME,'%m/%d/%Y %H:%i')) < '" .(date_format($higher,"G:i")) . "' UNION ");
		} else {
			$sql .= ("SELECT DISTINCT '" 
			     . (date_format($lower,"G:i")) .
				"' AS TIME_INTERVAL, BIKEID
				FROM trips_data 
				WHERE '" . (date_format($lower,"G:i")) . "'<= TIME(STR_TO_DATE(STARTTIME,'%m/%d/%Y %H:%i')) AND 
				TIME(STR_TO_DATE(STOPTIME,'%m/%d/%Y %H:%i')) < '" .(date_format($higher,"G:i")) . "'");
		}
    
  		date_add($lower, date_interval_create_from_date_string( $intervals . " minutes"));
		date_add($higher, date_interval_create_from_date_string( $intervals . " minutes"));	
	}
	
print($sql);
/*	$query = mysql_query($sql);
	if ( ! $query ) {
		echo mysql_error();
		die;
	}
    
	$data = array();
	for ($x = 0; $x < mysql_num_rows($query); $x++) {
		$data[] = mysql_fetch_assoc($query);
	}
	echo json_encode($data);     
	mysql_close($server);*/
?>