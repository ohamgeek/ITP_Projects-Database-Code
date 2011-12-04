<?php 
require "info.php";
if (isset($_REQUEST['projectid'])) {
	$projectid = $_REQUEST['projectid'];
	$dbc = mysql_connect($host,$un,$pw,$db);
	if (!$dbc) {
		die("ERROR!!! No Connection: ".mysql_errno() . ", ".mysql_error());
	}
	
	$db_selected = mysql_select_db($db,$dbc);
	if (!$db_selected) {
		die("ERROR!!! No database with that name: ".mysql_errno() . ", ".mysql_error());
	}
	
	$query = "SELECT p.project_id, p.project_name, p.elevator_pitch, p.description, p.url, pD.document FROM project p, projectDocuments pD, userProject uP WHERE p.project_id = uP.project_id AND p.project_id = pD.project_id AND pD.main_image = 1 AND p.project_id = $projectid;";
	$result = mysql_query($query,$dbc);
	if (!$result) {
		die("ERROR!!! This was a crummy query. ".mysql_errno() . ", ".mysql_error());
	}
	
	$forJSON = array();
	$count = 0;
	
	while($row = mysql_fetch_array($result, MYSQL_NUM)) {
		$forJSON[$count] = $row;
		$count++;
	}
	
	echo json_encode($forJSON);
} else {
	echo "Please specify a project id to pull from the database. Your query might look like this: <br />http://itp.nyu.edu/~mah593/pdb_serving_scripts/get_basic_portfolio.php<span style=\"color:#f00;\">?projectid=1111</span>";
}

?>