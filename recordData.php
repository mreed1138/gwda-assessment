<?php
session_start();
	include ("connection.php");
	//print_r($_POST);

	$dataRow = "";
	$dataRowPoint = "";
	$lastElement = end($_POST['json']);

	foreach($_POST['json'] as $obj):

		$c = ($obj != $lastElement)? ",":"";

		$dataRow .= "`{$obj['topic']}_{$obj['subtopic']}`{$c}";
		$dataRowPoint .= "{$obj['point']}{$c}";
	endforeach;

	//print_r($dataRow);
	//print_r($dataRowPoint);

	$query = "INSERT INTO `student_new` (`s_id`,`qtr`,`c_id`,`reviewer`,{$dataRow}) VALUES ('{$_POST['details']['sid']}', '{$_POST['details']['qtr']}', '{$_POST['details']['cid']}', '{$_SESSION['initials']}',{$dataRowPoint})";

//echo $query;

	$mysqli->query($query);
	echo true;
?>