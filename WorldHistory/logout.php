<?php
	session_start();
	include("controller/c_WorldHistory.php");
	$c_worldHistory = new c_WorldHistory();
	$c_worldHistory->logout_account();
?>