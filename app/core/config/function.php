<?php
function show($data){
	echo "<pre>";
	print_r($data);
	echo "</pre>";
}

function query(string $query, array $data=[]){
	$string = "mysql:hostname=".DBHOST. ";dbname=".DBNAME;
	$con = new PDO($string, DBUSER, DBPASS);

	$stm = $con->prepare($query);
	$stm->execute($data);

	$result = $stm->fetchAll(PDO::FETCH_ASSOC);
	if(is_array($result) && !empty($result)) {
		return $result;
	}
	return false;
}

function query_one(string $query, array $data=[]){
	$string = "mysql:hostname=".DBHOST. ";dbname=".DBNAME;
	$con = new PDO($string, DBUSER, DBPASS);

	$stm = $con->prepare($query);
	$stm->execute($data);

	$result = $stm->fetchAll(PDO::FETCH_ASSOC);
	if(is_array($result) && !empty($result)) {
		return $result[0];
	}
	return false;
}

function redirect($pagename) {
	header('location:'.ROOT.$pagename);
	die;
}

function former_value($key, $default = "") {
	if(!empty($_POST[$key])) {
		return $_POST[$key];
	}
	return $default;


}




