<?php

$host = 'localhost';
$user = 'root';
$pwd = '1234';
$db = 'nurseryvan_db';

$conn = mysqli_connect($host, $user, $pwd, $db);

if(!$conn){
	die("Error in connection: ".mysqli_connect_error());
	
	
	
}

$response = array();

$sql_query = "Select count(*) as 'CountCriticalBranch' from (SELECT count(nurseryvan_db.tbl_store.store_id)  from nurseryvan_db.tbl_inventory inner join nurseryvan_db.tbl_store on nurseryvan_db.tbl_store.store_id = nurseryvan_db.tbl_inventory.store_id where nurseryvan_db.tbl_inventory.status_pending  = 'Not Available' group by nurseryvan_db.tbl_store.store_name order by count(nurseryvan_db.tbl_store.store_name)) as DerivedTableAlias;";
$result = mysqli_query($conn, $sql_query);


if(mysqli_num_rows($result) > 0){
	$response['success'] = 1;
	$branches = array();
	while ($row = mysqli_fetch_assoc($result)){
		
		array_push($branches, $row);
		
		
	}
	$response['CriticalBranches'] = $branches;
	
}
else{
	
	$response['success'] = 0;
	$response['message'] = 'No data';
	
	
}

echo json_encode($response);
mysqli_close($conn);





?>
